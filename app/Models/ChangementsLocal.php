<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangementsLocal extends Model
{
    use HasFactory;

    // Spécifie la table associée à ce modèle
    protected $table = 'changements';

    // Spécifie la connexion de base de données utilisée (mysql2)
    protected $connection = 'mysql2'; // Utilise la connexion définie dans `config/database.php`

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'IDchangements';

    // Indique que la clé primaire est auto-incrémentée
    public $incrementing = true;

    // Le type de la clé primaire
    protected $keyType = 'int';

    // Active la gestion des timestamps
    public $timestamps = false;

    // Définit les champs autorisés pour l'assignation de masse
    protected $fillable = [
        'idprogrammes',
        'IdFiche',
        'Date_saisie',
        'Date_pose',
        'REFERENCE',
        'telephones',
        'adresse_crm',
        'ak_adresse_site',
        'tarif_crm',
        'compteur_crm',
        'compteur_crm_type',
        'compteur_crm_index',
        'compteur_crm_ps',
        'mode_paiement',
        'branch_crm',
        'ak_compteur_sur_site',
        'ak_compteur_site_type',
        'ak_compteur_site_index',
        'ak_compteur_site_ps',
        'ak_type_fraude',
        'ak_compteur_nouveau',
        'ak_compteur_nouveau_ps',
        'ak_compteur_nouveau_type',
        'ak_type_block',
        'ak_module_communication',
        'ak_index_pose_nouveau',
        'ak_tarif_nouveau',
        'ak_SIM',
        'ak_scelle_coffret_1',
        'ak_scelle_coffret_2',
        'ak_scelle_compteur_1',
        'ak_scelle_compteur_2',
        'ak_scelle_compteur_3',
        'ak_gps_lat',
        'ak_gps_long',
        'ak_branch_site',
        'ak_mode_sortie_alimentation',
        'ak_anomalie',
    ];
}
