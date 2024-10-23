<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangementsLocal extends Model
{
    use HasFactory;
    protected $table = 'changements_local'; // Spécifie la table si nécessaire

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'IDchangements';

    // Si ta clé primaire n'est pas un entier auto-incrémenté, indique-le
    public $incrementing = true;

    // Si ta clé primaire n'est pas de type "int", spécifie le type
    protected $keyType = 'int';
}
