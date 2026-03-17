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
        Schema::create('tache', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tache')->autoIncrement();
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->enum('statut', ['à faire', 'en cours', 'terminée'])->default('à faire');
            $table->enum('priorite', ['basse', 'moyenne', 'haute'])->default('moyenne');
            $table->date('date_creation')->useCurrent();
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin_prevue')->nullable();
            $table->unsignedBigInteger('id_projet');
            $table->unsignedBigInteger('id_epic')->nullable();
            $table->unsignedInteger('id_sprint')->nullable();
            $table->unsignedBigInteger('id_utilisateur')->nullable();

            $table->foreign('id_epic', 'fk_tache_epic_projet')
                  ->references('id_epic')
                  ->on('epic')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_sprint', 'fk_tache_sprint')
                  ->references('id_sprint')
                  ->on('sprint')
                  ->onDelete('set null');

            $table->index(['id_epic', 'id_projet'], 'fk_tache_epic_projet');
            $table->index(['id_sprint', 'id_projet'], 'fk_tache_sprint_projet');
            $table->index(['id_epic', 'id_sprint'], 'fk_tache_epic_sprint');
            $table->index(['id_projet', 'id_utilisateur'], 'fk_tache_membre_projet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tache');
    }
};
