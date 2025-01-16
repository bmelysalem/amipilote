<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->string('groupe')->nullable(); // Groupe (e.g., AMI, HES)
            $table->string('libelle'); // Libellé du service
            $table->integer('port_interne')->nullable(); // Port Interne
            $table->integer('port_externe')->nullable(); // Port Externe
            $table->string('ip_interne')->nullable(); // IP Interne
            $table->string('ip_publique')->nullable(); // IP Publique
            $table->string('adresse_dns')->nullable(); // Adresse DNS
            $table->string('image_icon')->nullable(); // Chemin ou URL de l'icône
            $table->boolean('is_api')->default(false); // Indique si le service est une API
            $table->boolean('admin_received')->default(false); // Indique si l'admin a reçu les données

            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
