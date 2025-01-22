<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', // Lien avec le modèle Service
        'title',      // Titre du document
        'category',   // Catégorie du document
        'file_path',  // Chemin du fichier
    ];

    // Relation avec le modèle Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
