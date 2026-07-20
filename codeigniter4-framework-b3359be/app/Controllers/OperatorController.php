<?php

namespace App\Controllers;
use App\Models\ClientModel;
use App\Models\HistoriqueModel;

class OperatorController extends BaseController
{
    public function __construct(){
        $this->clientModel = new ClientModel();
        $this->historiqueModel = new HistoriqueModel();
    }
    public function index(){
        $session = session();
        $clientId = $session->get('client_id');
        if(!$clientId){
            $session->setFlashdata("error", "Vous devez vous connecter pour accéder à cette page.");
            return redirect()->to('/login');
        }
        $benefice = $this->historiqueModel->selectSum('frais')->first();
        $beneficeRetrait = $this->historiqueModel->selectSum('frais')->where('type_operation_id', 2)->first();
        $beneficeTransfert = $this->historiqueModel->selectSum('frais')->where('type_operation_id', 3)->first();
        $beneficeOperateur = $this->historiqueModel->selectSum('commission')->first();
        return view('operateur/dashboard', ['benefice' => $benefice['frais'] ?? 0, 'retrait' => $beneficeRetrait['frais'] ?? 0, 'transfert' => $beneficeTransfert['frais'] ?? 0, 'gainOperateur' => $beneficeOperateur['commission'] ?? 0]);
    }
}