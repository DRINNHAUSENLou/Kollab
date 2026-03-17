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
        Schema::create('projet', function (Blueprint $table) {
            $table->integer('id_projet')->autoIncrement();
            $table->string('nom', 255)->nullable();
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_creation');
            $table->dateTime('date_fin_prevue')->nullable();
            $table->text('description')->nullable();
            $table->enum('statut', ['en attente', 'en cours', 'terminé'])->default('en attente');
            $table->enum('priorite', ['basse', 'moyenne', 'haute'])->default('moyenne');
            $table->unsignedBigInteger('chef_id')->nullable();

            $table->foreign('chef_id', 'fk_projet_chef')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet');
    }
};
