<?php

namespace App\Controllers;

class ClientController extends BaseController
{
    private $clientModel;
    private $historiqueModel;
    
    public function __construct(){
        $this->clientModel = model('App\\Models\\ClientModel');
        $this->historiqueModel = model('App\\Models\\HistoriqueModel');
    }
    public function index(){
        $session = session();
        $clientId = $session->get('client_id');
        if(!$clientId){
            $session->setFlashdata("error", "Vous devez vous connecter pour accéder à cette page.");
            return redirect()->to('/login');
        }
        $clients = $this->clientModel->getClientById($clientId);
        return view('client/home', ['clients' => $clients]);
    }
     public function list(): string
    {
        $client = $this->clientModel->findAll();
        return view('operateur/situationCompte', ['clients' => $client ]);
    }
    public function historique($id){
        $client = $this->clientModel->getClientById($id);
        $historiques = $this->historiqueModel->findbyIdClient($id);
        return view('operateur/historique', [
            'historiques' => $historiques,
            'clientSolde' => $client['solde'] ?? 0,
        ]);
    }
}