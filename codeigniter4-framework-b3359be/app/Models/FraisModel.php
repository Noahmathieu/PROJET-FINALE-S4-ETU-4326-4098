<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_type_operation',
        'montant_Min',
        'montant_Max',
        'valeur',
        'montant_min',
        'montant_max',
        'frais_transfert',
        'frais_retrait',
        'frais_depot',
    ];

    public function getFrais($montant, $typeOperation)
    {
        
        $frais = $this->where('montant_Min <=', $montant)
                    ->where('montant_Max >=', $montant)
                    ->where('id_type_operation', $typeOperation)
                    ->first();
        return $frais;
    }

    public function getFraisTransfertEtRetrait($montant): ?array
    {
        $fields = $this->db->getFieldNames($this->table);

        if (in_array('frais_transfert', $fields, true) && in_array('frais_retrait', $fields, true)) {
            $frais = $this->where('montant_min <=', $montant)
                ->where('montant_max >=', $montant)
                ->first();

            if (!$frais) {
                return null;
            }

            return [
                'transfert' => (float) $frais['frais_transfert'],
                'retrait' => (float) $frais['frais_retrait'],
            ];
        }

        $fraisTransfert = $this->getFrais($montant, 1);
        $fraisRetrait = $this->getFrais($montant, 2);

        if (!$fraisTransfert || !$fraisRetrait) {
            return null;
        }

        return [
            'transfert' => (float) $fraisTransfert['valeur'],
            'retrait' => (float) $fraisRetrait['valeur'],
        ];
    }

    public function getFraisDepot($montant): ?float
    {
        $fields = $this->db->getFieldNames($this->table);

        if (in_array('frais_depot', $fields, true)) {
            $frais = $this->where('montant_min <=', $montant)
                ->where('montant_max >=', $montant)
                ->first();

            return $frais ? (float) $frais['frais_depot'] : null;
        }

        $fraisDepot = $this->getFrais($montant, 3);

        return $fraisDepot ? (float) $fraisDepot['valeur'] : null;
    }
}
