<?php

namespace App\Models;

use CodeIgniter\Model;

class AutresOperateursModel extends Model
{
    protected $table = 'autres_operateurs';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'prefixe',
        'nomOperateur'
    ];
    public function checkOtherOperator($destinataire)
    {
        $prefixe = substr($destinataire, 0, 3);
        return $this->where('prefixe', $prefixe)->first();
    }
}
