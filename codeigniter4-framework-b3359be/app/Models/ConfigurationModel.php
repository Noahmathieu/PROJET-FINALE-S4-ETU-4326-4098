<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigurationModel extends Model
{
    protected $table = 'configuration';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'prefixe',
    ];

    public function checkMyOperator($numero)
    {
        $prefixe = substr($numero, 0, 3);
        return $this->where('prefixe', $prefixe)->first();
    }
}
