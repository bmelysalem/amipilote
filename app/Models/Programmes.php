<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programmes extends Model
{
    protected $table = 'programmes'; // Spécifie la table si nécessaire

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'idprogrammes';

    // Si ta clé primaire n'est pas un entier auto-incrémenté, indique-le
    public $incrementing = true;

    // Si ta clé primaire n'est pas de type "int", spécifie le type
    protected $keyType = 'int';

    // Relation avec ProgrammesDet
    public function details()
    {
        return $this->hasMany(ProgrammesDet::class, 'idprogrammes', 'idprogrammes');
    }
}
