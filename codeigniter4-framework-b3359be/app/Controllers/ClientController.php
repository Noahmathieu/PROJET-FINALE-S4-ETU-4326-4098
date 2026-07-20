<?php

namespace App\Controllers;

use App\Models\ClientModel;

class ClientController extends BaseController
{
    public function __construct(){
        $this->clientModel = new ClientModel();
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
}