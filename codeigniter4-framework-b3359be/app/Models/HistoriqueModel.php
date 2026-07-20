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

    public function findbyIdClient($clientId)
    {
        return $this->join('type_operation', 'type_operation.id = historique.type_operation_id')
                    ->where('client_id', $clientId)
                    ->orderBy('date_operation', 'DESC')->findAll();
    }
    public function getHistoriqueWithType($clientId)
    {
        return $this->select('historique.*, type_operation.nomType')
                    ->join('type_operation', 'type_operation.id = historique.type_operation_id')
                    ->where('historique.client_id', $clientId)
                    ->orderBy('historique.date_operation', 'DESC')
                    ->findAll();
    }

    public function commissionParOperateur(){
    $sql = "
        SELECT
            ao.nomOperateur,
            SUM(n.frais) AS total_commission
        FROM (
            SELECT
                h.*,
                CASE
                    WHEN h.destinataire LIKE '+261%' THEN substr(h.destinataire, 5, 2)
                    WHEN h.destinataire LIKE '261%'  THEN substr(h.destinataire, 4, 2)
                    WHEN h.destinataire LIKE '0%'    THEN substr(h.destinataire, 2, 2)
                END AS prefixe_client
            FROM historique h
            WHERE h.frais IS NOT NULL
                AND h.destinataire IS NOT NULL
        ) n
        JOIN autres_operateurs ao ON ltrim(ao.prefixe, '0') = n.prefixe_client
        GROUP BY ao.nomOperateur
        ORDER BY total_commission DESC
    ";

    return $this->db->query($sql)->getResultArray();
    }
}
