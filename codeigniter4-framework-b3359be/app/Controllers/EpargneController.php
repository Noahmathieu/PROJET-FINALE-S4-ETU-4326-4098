<?php

namespace App\Controllers;

use App\Models\EpargneModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class EpargneController extends BaseController
{
    private EpargneModel $epargneModel;

    public function __construct()
    {
        $this->epargneModel = new EpargneModel();
    }

    public function form(): string
    {

        $session = session();
        $id = $session->get("client_id");
        $epargne = $this->epargneModel->findByIdClient($id);
        return view('client/epargne', ['epargne' => $epargne]);
    }
    public function ajouter(): RedirectResponse
    {
        $session = session();
        $id = $session->get("client_id");
        $this->epargneModel->update($id,['epargne' => $this->request->getPost('epargne'),'client_id' => $id]);
        return redirect()->to(base_url('client/home'));

    }   
    
}
