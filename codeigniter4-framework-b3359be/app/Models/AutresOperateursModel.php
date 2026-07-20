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
    ];

}
