<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ConfigurationModel;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->configurationModel = new ConfigurationModel();
        $this->session = session();
    }
    public function login()
    {
        if ($this->session->get('client_id')) {
            $clientId = $this->session->get('client_id');
            if ($clientId === '1234567890') {
                return redirect()->to('/operator/home');
            } else {
                return redirect()->to('/client/home');
            }
        }
        return view('auth/login');
    }
    public function checkLogin()
    {
        $numeroAdmin='1234567890';

        $numero = $this->request->getPost('numero');

        if($numero === $numeroAdmin) {
            $this->session->set('client_id', $numeroAdmin);
            return redirect()->to('operator/home')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        } else {
        $this->clientModel->where('numero', $numero)->first();

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
        
        if (!preg_match($regex, $numero)) {
            $this->session->setFlashdata('error', 'Le format du numéro est invalide');
            return redirect()->back();
        }

        $client = $this->clientModel->getClientByNumero($numero);
        if ($client) {
            $this->session->set('client_id', $client['id']);
            return redirect()->to('client/home')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        } else {
            $this->clientModel->insert(['numero' => $numero, 'solde' => 0]);
            $this->session->set('client_id', $this->clientModel->getInsertID());
            return redirect()->to('client/home')->with('success', 'Bienvenue, vous êtes connecté avec succès.');
        }
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}