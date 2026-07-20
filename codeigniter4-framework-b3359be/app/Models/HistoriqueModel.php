<?php
namespace App\Models;

use CodeIgniter\Model;
class HistoriqueModel extends Model
{
    protected $table = 'historique';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'type_operation_id', 'montant', 'date_operation','frais','destinataire'];
}