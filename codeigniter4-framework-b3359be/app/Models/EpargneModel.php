<?php
namespace App\Models;
use CodeIgniter\Model;
class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['epargne', 'client_id'];

    public function findByIdClient($idClient){
        return $this->where('client_id',$idClient)->first();
    }
}