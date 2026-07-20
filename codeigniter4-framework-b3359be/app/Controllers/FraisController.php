<?php

namespace App\Controllers;

use App\Models\FraisModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class FraisController extends BaseController
{
    private FraisModel $fraisModel;

    public function __construct()
    {
        $this->fraisModel = new FraisModel();
    }

    public function list(): string
    {
        $frais = $this->fraisModel->findAll();
        return view('operateur/frais', ['frais' => $frais]);
    }
    public function ajouter(): RedirectResponse
    {
        $this->fraisModel->save([
            'montant_Min' => $this->request->getPost('montant_Min'),
            'montant_Max' => $this->request->getPost('montant_Max'),
            'valeur' => $this->request->getPost('valeur')
        ]);
        return redirect()->to(base_url('frais'));
    }
    public function modifier($id): RedirectResponse
    {
        $this->fraisModel->update($id, [
            'montant_Min' => $this->request->getPost('montant_Min'),
            'montant_Max' => $this->request->getPost('montant_Max'),
            'valeur' => $this->request->getPost('valeur')
        ]);
        return redirect()->to(base_url('frais'));
    }
    public function supprimer($id): RedirectResponse
    {
        $this->fraisModel->delete($id);
        return redirect()->to(base_url('frais'));
    }
    
   
    
}
