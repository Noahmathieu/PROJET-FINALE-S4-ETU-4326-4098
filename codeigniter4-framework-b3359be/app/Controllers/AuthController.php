<?php
namespace App\Controllers;

use App\Models\ClientModel;
class AuthController extends BaseController
{
    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->session = session();
    }
    public function login()
    {
        return view('auth/login');
    }
    public function checkLogin()
    {
        $numeroAdmin='1234567890';

        $numero = $this->request->getPost('numero');

        if($numero === $numeroAdmin) {
            $this->session->set('client_id', $numeroAdmin);
            return redirect()->to('/dashboard')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        } else {
        $this->clientModel->where('numero', $numero)->first();

        $regex = '/^(?:\+261|261|0)(33|34|38|37|20)\d{7}$/';
        
        if (!preg_match($regex, $numero)) {
            $this->session->setFlashdata('error', 'Le format du numéro est invalide.');
            return redirect()->back();
        }

        $client = $this->clientModel->getClientByNumero($numero);
        if ($client) {
            $this->session->set('client_id', $client['id']);
            return redirect()->to('/dashboard')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        } else {
            $this->clientModel->insert(['numero' => $numero, 'solde' => 0]);
            $this->session->set('client_id', $this->clientModel->getInsertID());
            return redirect()->to('/dashboard')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        }
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}