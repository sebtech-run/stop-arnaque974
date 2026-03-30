<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scams', function (Blueprint $table) {
            $table->id();

            // Informations sur l'arnaque
            $table->string('title'); // Ex: "SMS Colis en attente"
            $table->string('type'); // Ex: "Phishing", "Vente Facebook", "Ransomware"
            $table->text('description'); // Le récit complet de la victime

            // Les indicateurs (Crucial pour ta barre de recherche plus tard)
            $table->string('scammer_phone')->nullable(); // Ex: 0692123456
            $table->string('scammer_email')->nullable(); // Ex: service@faux-paypal.com
            $table->string('scammer_url')->nullable();   // Ex: http://arnaque-livraison.com

            // Preuves
            $table->json('evidence_paths')->nullable(); // Stockera les chemins des images (screenshots)

            // Gestion de la modération (Ton rôle de régulateur)
            // pending = en attente, validated = publié, rejected = refusé
            $table->string('status')->default('pending')->index();

            // Raison du refus (optionnel, pour expliquer à l'utilisateur)
            $table->text('rejection_reason')->nullable();

            // Liaison utilisateur (Optionnel : nullable si tu acceptes les signalements anonymes)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Localisation (Optionnel, mais intéressant pour le 974)
            $table->string('location')->default('974');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scams');
    }
};
