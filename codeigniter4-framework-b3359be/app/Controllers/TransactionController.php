<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ConfigurationModel;
use App\Models\FraisModel;
use App\Models\HistoriqueModel;

class TransactionController extends BaseController
{
    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->configurationModel = new ConfigurationModel();
        $this->historiqueModel = new HistoriqueModel();
        $this->fraisModel = new FraisModel();
    }
    public function retrait(){
        return view('transaction/retrait');
    }
    public function depot(){
        return view('transaction/depot');
    }
    public function transfer(){
        return view('transaction/transfert');
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
    public function valideTransfert(){

    $session = session();
    $id = $session->get("client_id");
        $destinataire = $this->request->getPost("destinataire");
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

            $prefPattern = implode('|', $allowedPrefixes);

            $regex = '/^(?:\+261|261|0)(' . $prefPattern . ')\d{7}$/';
        
        if (!preg_match($regex, $destinataire)) {
            $session->setFlashdata('error', 'Le format du numéro est invalide');
            return redirect()->back();
        }

        $montant = $this->request->getPost("montant");

        $frais = $this->fraisModel->getFrais($montant,2);
        $sommeMontant = $montant + $frais['valeur'];

        $session = session();

        $id = $session->get('client_id');
        $client = $this->clientModel->find($id);
        if (!$client || $client['solde'] < $sommeMontant) {
            return redirect()->back()->with('error', 'Solde insuffisant pour couvrir le retrait et les frais.');
        }
        
        $this->clientModel->updateSoldeById($id,-$sommeMontant);
        $this->clientModel->updateSoldeByNumero($destinataire,$montant);
        $this->historiqueModel->insert([
            'client_id' => session()->get('client_id'),
            'type_operation_id' => 3,
            'montant' => $montant,
            'frais' => $frais['valeur'],
            'date_operation' => date('Y-m-d H:i:s'),
            'destinataire' => $destinataire
        ]);
        $session->setFlashdata('success', 'Transfert effectue avec succes.');
        return redirect()->to('/client/transfert');
    }
    public function historique(){
        $session = session();
        $id = $session->get("client_id");
        $transactions = $this->historiqueModel->where('client_id', $id)->orderBy('date_operation', 'DESC')->findAll();
        return view('client/historique', ['transactions' => $transactions]);
    }
}