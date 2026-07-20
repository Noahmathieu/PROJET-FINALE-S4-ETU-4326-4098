<?php
namespace App\Models;

use CodeIgniter\Model;
class HistoriqueModel extends Model
{
    protected $table = 'historique';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'type_operation_id', 'montant', 'date_operation','frais','destinataire'];

    public function getHistoriqueWithType($clientId)
    {
        return $this->select('historique.*, type_operation.nomType')
                    ->join('type_operation', 'type_operation.id = historique.type_operation_id')
                    ->where('historique.client_id', $clientId)
                    ->orderBy('historique.date_operation', 'DESC')
                    ->findAll();
    }
}
