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
        Schema::create('epic', function (Blueprint $table) {
            $table->unsignedBigInteger('id_epic')->autoIncrement();
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->enum('priorite', ['basse', 'moyenne', 'haute'])->default('moyenne');
            $table->enum('statut', ['a_faire', 'en_cours', 'fini'])->default('a_faire');
            $table->string('couleur', 24)->nullable();
            $table->integer('id_projet');

            $table->unique(['id_epic', 'id_projet'], 'uq_epic_projet');

            $table->foreign('id_projet', 'fk_epic_projet')
                  ->references('id_projet')
                  ->on('projet')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epic');
    }
};
