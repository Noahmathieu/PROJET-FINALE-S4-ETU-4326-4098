<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientModel extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['numero', 'solde'];

    public function getClientByNumero($numero)
    {
        return $this->where('numero', $numero)->first();
    }
    public function getClientById($id){
        return $this->where('id', $id)->first();
    }
    
}