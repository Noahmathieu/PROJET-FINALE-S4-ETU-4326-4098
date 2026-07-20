<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'montant_Min',
        'montant_Max',
        'valeur'
    ];
    public function getFrais($montant,$typeOperation){
        
        $frais = $this->where('montant_Min <=', $montant)
                    ->where('montant_Max >=', $montant)
                    ->where('id_type_operation', $typeOperation)
                    ->first();
        return $frais;
    }
}
