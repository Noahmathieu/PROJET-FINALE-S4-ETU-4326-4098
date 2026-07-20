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
    public function updateSoldeById($id, $soldeAdd)
    {
        $client = $this->getClientById($id);
        if ($client) {
            $soldeActuel = $client['solde'];
            $nouveauSolde = $soldeActuel + $soldeAdd;
            return $this->where('id', $id)->set('solde', $nouveauSolde)->update();
        }
        return false;
    }
    public function updateSoldeByNumero($numero, $soldeAdd)
    {
        $montantFinale = $this->select('solde')->where('numero', $numero)->first();
        if (!$montantFinale) {
            return false;
        }
            $soldeActuel = $montantFinale['solde'];
            $nouveauSolde = $soldeActuel + $soldeAdd;
            return $this->where('numero', $numero)->set('solde', $nouveauSolde)->update();
    }
}