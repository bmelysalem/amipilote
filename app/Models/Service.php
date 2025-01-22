<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupe',
        'libelle',
        'port_interne',
        'port_externe',
        'ip_interne',
        'ip_publique',
        'adresse_dns',
        'image_icon',
        'is_api',
        'admin_received',
        'description',
    ];

    // Relation avec le modèle Document
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
