<?php

namespace App\Controllers;

use App\Models\TypeOperationModel;
use CodeIgniter\HTTP\ResponseInterface;

class TypeOperationController extends BaseController
{
    private TypeOperationModel $typeOpModel;

    public function __construct()
    {
        $this->typeOpModel = new TypeOperationModel();
    }
    
    public function list(): string
    {
        $typeOperations = $this->typeOpModel->findAll();
        return view('operateur/typeOperation', ['typeOperations' => $typeOperations]);
    }

    public function ajouter(): ResponseInterface
    {
        $this->typeOpModel->save([
            'nomType' => $this->request->getPost('nomType'),
        ]);
        return redirect()->to(base_url('typeOperation'));
    }
    
    public function modifier($id): ResponseInterface
    {
        $this->typeOpModel->update($id, [
            'nomType' => $this->request->getPost('nomType'),
        ]);
        return redirect()->to(base_url('typeOperation'));
    }
    
    public function supprimer($id): ResponseInterface
    {
        $this->typeOpModel->delete($id);
        return redirect()->to(base_url('typeOperation'));
    }
    
}
