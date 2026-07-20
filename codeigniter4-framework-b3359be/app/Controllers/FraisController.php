<?php

namespace App\Controllers;

use App\Models\FraisModel;
use App\Models\TypeOperationModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class FraisController extends BaseController
{
    private FraisModel $fraisModel;
    private TypeOperationModel $typeOperationModel;

    public function __construct()
    {
        $this->fraisModel = new FraisModel();
        $this->typeOperationModel = new TypeOperationModel();
    }

    public function list(): string
    {
        $frais = $this->fraisModel->findAll();
        $typeOperations = $this->typeOperationModel->findAll();
        return view('operateur/frais', ['frais' => $frais , 'typeOperations' => $typeOperations]);
    }
    public function ajouter(): RedirectResponse
    {
        $this->fraisModel->save([
            'id_type_operation' => $this->request->getPost('id_type_operation'),
            'montant_Min' => $this->request->getPost('montant_Min'),
            'montant_Max' => $this->request->getPost('montant_Max'),
            'valeur' => $this->request->getPost('valeur')
        ]);
        return redirect()->to(base_url('frais'));
    }
    public function modifier($id): RedirectResponse
    {
        $this->fraisModel->update($id, [
            'id_type_operation' => $this->request->getPost('id_type_operation'),
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
