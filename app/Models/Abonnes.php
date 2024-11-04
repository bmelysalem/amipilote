<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\KeyCalculationService;

class Abonnes extends Model
{
    protected $table = 'abonnes'; // Spécifie la table si nécessaire

    // Spécifie la clé primaire personnalisée
    protected $primaryKey = 'IDabonnes';

    // Si ta clé primaire est un entier auto-incrémenté
    public $incrementing = true;

    // Si la clé primaire est de type 'bigint'
    protected $keyType = 'int';

    protected $appends = ['successeur']; // Ajouter 'successeur' aux attributs JSON

    // Si nécessaire, tu peux définir les relations avec d'autres modèles ici
    public function programmesdet()
    {
        return $this->hasMany(ProgrammesDet::class, 'REFERENCE', 'REFERENCE');
    }

    public function getSuccesseurAttribute()
    {
        // Récupérer les 9 premiers caractères de la référence
        $prefix = substr($this->REFERENCE, 0, 9);

        // Utiliser le service pour calculer la clé
        $keyCalculationService = app(KeyCalculationService::class);
        $key = $keyCalculationService->calculateKey($this->REFERENCE, 0);

        // Concaténer le préfixe et la clé en tant que chaîne
        return $prefix . implode('', $key);
    }
}
