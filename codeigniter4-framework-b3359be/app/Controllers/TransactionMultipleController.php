<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ConfigurationModel;
use App\Models\HistoriqueModel;
use App\Models\FraisModel;

class TransactionMultipleController extends BaseController
{
    private $clientModel;
    private $configurationModel;
    private $historiqueModel;
    private $fraisModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->configurationModel = new ConfigurationModel();
        $this->historiqueModel = new HistoriqueModel();
        $this->fraisModel = new FraisModel();
    }
    private function getCurrentClient(): ?array
    {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return null;
        }

        return $this->clientModel->getClientById($clientId);
    }

    public function retrait(){
        $client = $this->getCurrentClient();

        return view('transaction/retrait', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function depot(){
        $client = $this->getCurrentClient();

        return view('transaction/depot', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function transfertMultiple(){
        $client = $this->getCurrentClient();

        return view('transaction/transfertMultiple', [
            'soldeValue' => $client['solde'] ?? 0,
            'clientName' => $client['numero'] ?? 'Client',
        ]);
    }
    public function valideDepot(){
        $montant = $this->request->getPost("montant");

        $session = session();
        $id = $session->get("client_id");


        $this->clientModel->updateSoldeById($id, $montant);
        $this->historiqueModel->insert([
            'client_id' => session()->get('client_id'),
            'type_operation_id' => 1,
            'montant' => $montant,
            'frais' =>0,
            'date_operation' => date('Y-m-d H:i:s'),
            'destinataire' => null
        ]);
        $session = session();
        $session->setFlashdata('success', 'Depot effectue avec succes.');
        return redirect()->to('/client/depot');
    }
    public function valideRetrait(){
        $montant = $this->request->getPost("montant");
        $session = session();
        $id = $session->get("client_id");

        $frais = $this->fraisModel->getFrais($montant,2);
        $sommeMontant = $montant + $frais['valeur'];

        $client = $this->clientModel->find($id);
        if (!$client || $client['solde'] < $sommeMontant) {
            return redirect()->back()->with('error', 'Solde insuffisant pour couvrir le retrait et les frais.');
        }

        $this->clientModel->updateSoldeById($id,-$sommeMontant);
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

        $destinataires = $this->request->getPost("destinataires");
        $destinataires = array_unique(array_filter(array_map('trim', (array) $destinataires)));

        if (empty($destinataires)) {
            $session->setFlashdata('error', 'Veuillez renseigner au moins un destinataire');
            return redirect()->back();
        }

        $prefixesFromDb = $this->configurationModel->findAll();
        $allowedPrefixes = [];

        foreach ($prefixesFromDb as $config) {
            $cleanPrefix = ltrim($config['prefixe'], '0');
            if (!empty($cleanPrefix)) {
                $allowedPrefixes[] = $cleanPrefix;
            }
        }

        if (empty($allowedPrefixes)) {
            return redirect()->back()->with('error', 'Aucun préfixe autorisé trouvé dans la base de données.');
        }

        $prefPattern = implode('|', array_map(static fn ($prefix) => preg_quote($prefix, '/'), $allowedPrefixes));

        $regex = '/^(?:\+261|261|0)(' . $prefPattern . ')\d{7}$/';

        foreach ($destinataires as $destinataire) {
            if (!preg_match($regex, $destinataire)) {
                $session->setFlashdata('error', 'Le format du numéro ' . $destinataire . ' est invalide');
                return redirect()->back();
            }
        }

        $montant = filter_var($this->request->getPost("montant"), FILTER_VALIDATE_FLOAT);
        if ($montant === false || $montant <= 0) {
            $session->setFlashdata('error', 'Le montant doit être supérieur à zéro.');
            return redirect()->back();
        }

        $nbDestinataires = count($destinataires);
        $montantEnCentimes = (int) round($montant * 100);
        $montantParPersonneEnCentimes = intdiv($montantEnCentimes, $nbDestinataires);
        $centimesRestants = $montantEnCentimes % $nbDestinataires;

        if ($montantParPersonneEnCentimes === 0) {
            $session->setFlashdata('error', 'Le montant est trop faible pour être réparti entre tous les destinataires.');
            return redirect()->back();
        }

        $montantsParDestinataire = [];
        foreach ($destinataires as $index => $destinataire) {
            $montantsParDestinataire[$destinataire] = ($montantParPersonneEnCentimes + ($index < $centimesRestants ? 1 : 0)) / 100;
        }

        $fraisParDestinataire = [];
        $fraisTotal = 0;
        foreach ($montantsParDestinataire as $destinataire => $montantParPersonne) {
            $frais = $this->fraisModel->getFrais($montantParPersonne, 1);
            if (!$frais) {
                $session->setFlashdata('error', 'Aucun frais trouvé pour le montant envoyé à ' . $destinataire . '.');
                return redirect()->back();
            }
            $fraisParDestinataire[$destinataire] = (float) $frais['valeur'];
            $fraisTotal += (float) $frais['valeur'];
        }
        $sommeMontant = $montant + $fraisTotal;

        $clientsDestinataires = [];
        foreach ($destinataires as $destinataire) {
            $destinataireExists = $this->clientModel->getClientByNumero($destinataire);
            if (!$destinataireExists) {
                $session->setFlashdata('error', 'Le destinataire ' . $destinataire . ' n\'existe pas.');
                return redirect()->back();
            }
            $clientsDestinataires[$destinataire] = $destinataireExists;
        }

        $client = $this->clientModel->find($id);
        if (!$client || $client['solde'] < $sommeMontant) {
            return redirect()->back()->with('error', 'Solde insuffisant pour couvrir le transfert et les frais.');
        }

        $this->clientModel->updateSoldeById($id, -$sommeMontant);

        foreach ($destinataires as $destinataire) {
            $montantParPersonne = $montantsParDestinataire[$destinataire];
            $frais = $fraisParDestinataire[$destinataire];

            $this->clientModel->updateSoldeByNumero($clientsDestinataires[$destinataire]['numero'], $montantParPersonne);
            $this->historiqueModel->insert([
                'client_id' => session()->get('client_id'),
                'type_operation_id' => 1,
                'montant' => $montantParPersonne,
                'frais' => $frais,
                'date_operation' => date('Y-m-d H:i:s'),
                'destinataire' => $destinataire
            ]);
        }

        $session->setFlashdata('success', 'Transfert effectué avec succès.');
        return redirect()->to('/client/transfertMultiple');
    }
    public function historique(){
        $session = session();
        $id = $session->get("client_id");
        $transactions = $this->historiqueModel->getHistoriqueWithType($id);
        $client = $this->getCurrentClient();
        return view('client/historique', ['transactions' => $transactions,
        'soldeValue' => $client['solde'] ?? 0,
        'clientName' => $client['numero'] ?? 'Client',]);
    }
}
