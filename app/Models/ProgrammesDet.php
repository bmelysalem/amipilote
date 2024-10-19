<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammesDet extends Model
{
    protected $table = 'programmesdet'; // Spécifie la table si nécessaire

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
