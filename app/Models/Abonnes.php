<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnes extends Model
{
    protected $table = 'abonnes'; // Spécifie la table si nécessaire

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'IDabonnes';

    // Si ta clé primaire est un entier auto-incrémenté
    public $incrementing = true;

    // Si la clé primaire est de type 'bigint'
    protected $keyType = 'int';

    // Si nécessaire, tu peux définir les relations avec d'autres modèles ici
    public function programmesdet()
    {
        return $this->hasMany(ProgrammesDet::class, 'REFERENCE', 'REFERENCE');
    }
}
