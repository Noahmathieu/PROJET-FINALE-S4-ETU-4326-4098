<?php

namespace App\Controllers;

use App\Models\AutresOperateursModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class AutresOperateursController extends BaseController
{
    private AutresOperateursModel $autresOperateursModel;

    public function __construct()
    {
        $this->autresOperateursModel = new AutresOperateursModel();
    }

    public function form(): string
    {
        $prefixe = $this->autresOperateursModel->findAll();
        return view('operateur/autreOperateur', ['prefixe' => $prefixe]);
    }
    public function ajouter(): RedirectResponse
    {
        $this->autresOperateursModel->save(['prefixe' => $this->request->getPost('prefixe')]);
        return redirect()->to(base_url('autresOperateurs'));

    }
    public function supprimer($id): RedirectResponse
    {
        $this->autresOperateursModel->delete($id);
        return redirect()->to(base_url('autresOperateurs'));
    }
   
    
}
