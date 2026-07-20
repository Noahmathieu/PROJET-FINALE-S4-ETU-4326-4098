<?php

namespace App\Controllers;

use App\Models\ConfigurationModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class ConfigurationController extends BaseController
{
    private ConfigurationModel $configurationModel;

    public function __construct()
    {
        $this->configurationModel = new ConfigurationModel();
    }

    public function form(): string
    {
        $prefixe = $this->configurationModel->findAll();
        return view('operateur/configuration', ['prefixe' => $prefixe]);
    }
    public function ajouter(): RedirectResponse
    {
        $this->configurationModel->save(['prefixe' => $this->request->getPost('prefixe')]);
        return redirect()->to(base_url('config'));

    }
    public function supprimer($id): RedirectResponse
    {
        $this->configurationModel->delete($id);
        return redirect()->to(base_url('config'));
    }
   
    
}
