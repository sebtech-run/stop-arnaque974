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
        Schema::table('scams', function (Blueprint $table) {
            // On ajoute la colonne slug, on la met nullable pour l'instant
            // car les anciennes arnaques n'en ont pas encore
            $table->string('slug')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scams', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
