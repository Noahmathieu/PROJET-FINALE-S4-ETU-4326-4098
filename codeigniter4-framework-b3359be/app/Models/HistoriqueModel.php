<?php
namespace App\Models;

use CodeIgniter\Model;
class HistoriqueModel extends Model
{
    protected $table = 'historique';
    protected $primaryKey = 'id';

    protected $useTimestamps = false;
     protected $allowedFields = ['client_id', 'type_operation_id', 'montant','commission', 'date_operation','frais','destinataire'];


    public function findbyIdClient($clientId)
    {
        return $this->select('historique.*, type_operation.nomType as typeOperationNom')
                    ->join('type_operation', 'type_operation.id = historique.type_operation_id')
                    ->where('client_id', $clientId)
                    ->findAll();
    }

    public function getHistoriqueWithType($clientId)
    {
        return $this->select('historique.*, type_operation.nomType')
                    ->join('type_operation', 'type_operation.id = historique.type_operation_id')
                    ->where('historique.client_id', $clientId)
                    ->orderBy('historique.date_operation', 'DESC')
                    ->findAll();
    }

}