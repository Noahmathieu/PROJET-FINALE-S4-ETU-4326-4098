<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ConfigurationModel;
use App\Models\HistoriqueModel;
use App\Models\FraisModel;
use App\Models\CommissionModel;
use App\Models\PromotionModel;
use App\Models\AutresOperateursModel;


class TransactionController extends BaseController
{
    private $clientModel;
    private $configurationModel;
    private $historiqueModel;
    private $fraisModel;
    private $commissionModel;
    private $autresOperateursModel;
    private $promotionModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->configurationModel = new ConfigurationModel();
        $this->historiqueModel = new HistoriqueModel();
        $this->fraisModel = new FraisModel();
        $this->commissionModel = new CommissionModel();
        $this->autresOperateursModel = new AutresOperateursModel();
        $this->promotionModel = new PromotionModel();
    }
    private function getCurrentClient(): ?array
    {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return null;
        }

        return $this->clientModel->getClientById($clientId);
    }

    private function normaliserNumero($numero): string
    {
        $numero = preg_replace('/\D+/', '', (string) $numero);

        if (str_starts_with($numero, '261')) {
            return '0' . substr($numero, 3);
        }

        return $numero;
    }

    private function getPrefixeNumero($numero): string
    {
        return substr($this->normaliserNumero($numero), 0, 3);
    }

    private function prefixeExiste(string $prefixe, array $prefixes): bool
    {
        foreach ($prefixes as $config) {
            if (ltrim($config['prefixe'] ?? '', '0') === ltrim($prefixe, '0')) {
                return true;
            }
        }

        return false;
    }

    private function trouverAutreOperateur(string $prefixe): ?array
    {
        return $this->autresOperateursModel
            ->where('prefixe', $prefixe)
            ->orWhere('prefixe', ltrim($prefixe, '0'))
            ->first();
    }

    private function construireRegexNumeroAutorise(array $prefixesOperateur, array $prefixesAutresOperateurs): ?string
    {
        $allowedPrefixes = [];

        foreach (array_merge($prefixesOperateur, $prefixesAutresOperateurs) as $config) {
            $cleanPrefix = ltrim($config['prefixe'] ?? '', '0');

            if ($cleanPrefix !== '') {
                $allowedPrefixes[] = preg_quote($cleanPrefix, '/');
            }
        }

        $allowedPrefixes = array_unique($allowedPrefixes);

        if (empty($allowedPrefixes)) {
            return null;
        }

        $prefPattern = implode('|', $allowedPrefixes);

        return '/^(?:\+261|261|0)(' . $prefPattern . ')\d{7}$/';
    }

    private function calculerCoutTransfert(float $montant, string $destinataire, bool $inclureFraisRetrait): ?array
    {
        $prefixesOperateur = $this->configurationModel->findAll();
        $prefixesAutresOperateurs = $this->autresOperateursModel->findAll();
        $regexNumeroAutorise = $this->construireRegexNumeroAutorise($prefixesOperateur, $prefixesAutresOperateurs);

        if ($regexNumeroAutorise === null || !preg_match($regexNumeroAutorise, trim($destinataire))) {
            return null;
        }

        $numeroNormalise = $this->normaliserNumero($destinataire);
        $prefixe = $this->getPrefixeNumero($numeroNormalise);
        $estMemeOperateur = $this->prefixeExiste($prefixe, $prefixesOperateur);
        $autreOperateur = $this->trouverAutreOperateur($prefixe);
        $estAutreOperateur = $autreOperateur !== null;

        if (!$estMemeOperateur && !$estAutreOperateur) {
            return null;
        }

        $fraisTransfert = 0.0;
        $fraisRetrait = 0.0;
        $commission = 0.0;
        $promotion = 1;
        $montantRecu = $montant;

        if ($estMemeOperateur) {
            $frais = $this->fraisModel->getFraisTransfertEtRetrait($montant);

            if (!$frais) {
                return null;
            }

            $fraisTransfert = $frais['transfert'];
            $promotionConfig = $this->promotionModel->getPromotion();
            $tauxPromotion = (float) ($promotionConfig['promotion'] ?? 0);
            $promotion = $tauxPromotion;


            if ($inclureFraisRetrait) {
                $fraisRetrait = $frais['retrait'];
                $montantRecu = $montant + $fraisRetrait;
            }
        }

        if ($estAutreOperateur) {
            $fraisDepot = $this->fraisModel->getFraisDepot($montant);

            if ($fraisDepot === null) {
                return null;
            }

            $fraisTransfert = $fraisDepot;
            $commissionConfig = $this->commissionModel->getCommission();
            $tauxCommission = (float) ($commissionConfig['taux'] ?? 0);
            $commission = $montant * $tauxCommission;
            
        }

        return [
            'destinataire' => $numeroNormalise,
            'est_meme_operateur' => $estMemeOperateur,
            'autre_operateur' => $autreOperateur,
            'frais_transfert' => $fraisTransfert*$promotion,
            'frais_retrait' => $fraisRetrait,
            'commission' => $commission,
            'cout_total' => $montant + $fraisTransfert + $fraisRetrait + $commission,
            'montant_recu' => $montantRecu,
        ];
    }

    public function retrait()
    {
        $client = $this->getCurrentClient();

        return view('transaction/retrait', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function depot()
    {
        $client = $this->getCurrentClient();

        return view('transaction/depot', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function transfer()
    {
        $client = $this->getCurrentClient();

        return view('transaction/transfert', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function valideDepot()
    {
        $montant = $this->request->getPost("montant");

        $session = session();
        $id = $session->get("client_id");


        $this->clientModel->updateSoldeById($id, $montant);
        $this->historiqueModel->insert([
            'client_id' => session()->get('client_id'),
            'type_operation_id' => 1,
            'montant' => $montant,
            'frais' => 0,
            'date_operation' => date('Y-m-d H:i:s'),
            'destinataire' => null
        ]);
        $session = session();
        $session->setFlashdata('success', 'Depot effectue avec succes.');
        return redirect()->to('/client/depot');
    }
    public function valideRetrait()
    {
        $montant = $this->request->getPost("montant");
        $session = session();
        $id = $session->get("client_id");

        $frais = $this->fraisModel->getFrais($montant, 2);
        $sommeMontant = $montant + $frais['valeur'];

        $client = $this->clientModel->find($id);
        if (!$client || $client['solde'] < $sommeMontant) {
            return redirect()->back()->with('error', 'Solde insuffisant pour couvrir le retrait et les frais.');
        }

        $this->clientModel->updateSoldeById($id, -$sommeMontant);
        $this->historiqueModel->insert([
            'client_id' => session()->get('client_id'),
            'type_operation_id' => 2,
            'montant' => $montant,
            'frais' => $frais['valeur'],
            'date_operation' => date('Y-m-d H:i:s'),
            'destinataire' => null
        ]);
        $session->setFlashdata('success', 'Retrait effectue avec succes.');
        return redirect()->to('/client/retrait');
    }
    public function valideTransfert()
    {

        $session = session();
        $id = $session->get("client_id");
        $destinataire = $this->request->getPost("destinataire");
        $montant =  $this->request->getPost("montant");
        $inclureFraisRetrait = $this->request->getPost("inclure_frais_retrait") === '1';

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit etre superieur a zero.');
        }

        $calcul = $this->calculerCoutTransfert($montant, $destinataire, $inclureFraisRetrait);

        if (!$calcul) {
            return redirect()->back()->with('error', 'Numero destinataire invalide ou frais introuvables pour ce montant.');
        }

        $client = $this->clientModel->find($id);

        if (!$client || $client['solde'] < $calcul['cout_total']) {
            return redirect()->back()->with('error', 'Solde insuffisant pour couvrir le transfert et les frais.');
        }

        if ($calcul['est_meme_operateur'] && !$this->clientModel->getClientByNumero($calcul['destinataire'])) {
            return redirect()->back()->with('error', 'Destinataire introuvable chez cet operateur.');
        }

        $this->clientModel->updateSoldeById($id, -$calcul['cout_total']);

        if ($calcul['est_meme_operateur']) {
            $this->clientModel->updateSoldeByNumero($calcul['destinataire'], $calcul['montant_recu']);
        }
        $somme = $calcul['frais_transfert'] + $calcul['frais_retrait'] + $calcul['commission'];
        $this->clientModel->updateSoldeById($id, -$somme);
        $this->historiqueModel->insert([
            'client_id' => session()->get('client_id'),
            'type_operation_id' => 3,
            'montant' => $montant,
            'frais' => $calcul['frais_transfert'] + $calcul['frais_retrait'],
            'commission' => $calcul['commission'] > 0 ? $calcul['commission'] : null,
            'date_operation' => date('Y-m-d H:i:s'),
            'destinataire' => $calcul['destinataire']
        ]);

        $session->setFlashdata('success', 'Transfert effectue avec succes.');
        return redirect()->to('/client/transfert');
    }
    public function historique()
    {
        $session = session();
        $id = $session->get("client_id");
        $transactions = $this->historiqueModel->getHistoriqueWithType($id);
        $client = $this->getCurrentClient();
        return view('client/historique', [
            'transactions' => $transactions,
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
}
