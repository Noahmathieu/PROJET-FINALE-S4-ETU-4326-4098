<?php

namespace App\Controllers;

use App\Models\PromotionModel;
use App\Models\HistoriqueModel;

class PromotionController extends BaseController
{
    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    public function promotionForm(): string
    {

        $promotion = $this->promotionModel->findAll();
        return view('operateur/promotion', ['promotion' => $promotion['promotion']]);
    }

    // public function validate($id) {
    //     $promotion = $this->request->getPost('promotion');

    //     $this->$promotionModel->update($id,[
    //         'promotion'=> $promotion
    //     ]);

    //     return redirect()->to ('operateur/promotion');
    // }
    
}
