<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammesDet extends Model
{
    use HasFactory;

    // Liste des champs autorisés à être remplis via l'assignation de masse
    protected $fillable = [
        'idprogrammes',   // ID du programme auquel ce détail est associé
        'REFERENCE',      // Référence de l'abonné
        'compteur_pose',  // Par exemple, si un compteur a été posé
        'Branch_repris',  // D'autres attributs de la table ProgrammesDet
        'cas_cloture',    // Cas de clôture
        'compteur_ancien', // Ancien compteur
        'etat_abonne',    // État de l'abonné
        'date_saisie',    // Date de saisie
        'telephone_03',   // Téléphone
        'numposte',       // Numéro du poste
    ];
    protected $table = 'programmesdet'; // Spécifie la table si nécessaire

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'idprogemesdet';

    // Relation avec Programmes
    public function programme()
    {
        return $this->belongsTo(Programmes::class, 'idprogrammes', 'idprogrammes');
    }
    // Relation avec les abonnés via la colonne REFERENCE
    public function abonne()
    {
        return $this->belongsTo(Abonnes::class, 'REFERENCE', 'REFERENCE');
    }
}
