<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nouvabnt extends Model
{
    use HasFactory;

    // Spécifie la table associée à ce modèle
    protected $table = 'nouvabnt';

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'idnouvabnt';

    // Indique que la clé primaire est auto-incrémentée
    public $incrementing = true;

    // Le type de la clé primaire
    protected $keyType = 'int';

    // Désactive les timestamps automatiques
    public $timestamps = false;

    // Spécifie la connexion de base de données utilisée (mysql2)
    protected $connection = 'mysql2'; // Utilise la connexion définie dans `config/database.php`

    // Définit les champs autorisés pour l'assignation de masse
    protected $fillable = [
        'DATE',
        'REFERENCE',
        'Adresse',
        'TYPE_BRANCHEMENT',
        'type_mutation',
        'type_pre_post',
        'Compteur',
        'DATEPOSE',
        'OBSERVATIONS',
        'TARIF',
        'PS',
        'TELEPHONE_01',
        'statut',
        'gps_lat',
        'gps_long',
        'cree_ds_crm',
    ];
}
