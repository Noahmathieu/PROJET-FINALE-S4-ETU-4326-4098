<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientModel extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';

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
            if ($nouveauSolde < 0) {
                return "Solde insuffisant pour effectuer cette opération.";
            }
            return $this->where('id', $id)->set('solde', $nouveauSolde)->update();
        }
        return "Client non trouvé.";
    }
    public function updateSoldeByNumero($numero, $soldeAdd)
    {
        $montantFinale = $this->select('solde')->where('numero', $numero)->first();
        if (!$montantFinale) {
            return "Client non trouvé.";
        }
            $soldeActuel = $montantFinale['solde'];
            $nouveauSolde = $soldeActuel + $soldeAdd;
            if($nouve)
            return $this->where('numero', $numero)->set('solde', $nouveauSolde)->update();
    }
}