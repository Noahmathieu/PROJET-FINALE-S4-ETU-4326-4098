<?php

namespace App\Models;

use CodeIgniter\Model;
class CommissionModel extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'id';
    protected $allowedFields = ['taux'];

    public function getCommission()
    {
        return $this->first();
    }
}