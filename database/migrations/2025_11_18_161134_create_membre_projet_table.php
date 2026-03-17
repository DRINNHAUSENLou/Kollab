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
        Schema::create('membre_projet', function (Blueprint $table) {
            $table->integer('id_projet');
            $table->unsignedBigInteger('id_utilisateur');
            $table->enum('role', ['chef', 'editeur', 'lecteur']);
            $table->timestamp('date_ajout')->useCurrent();

            $table->primary(['id_projet', 'id_utilisateur']);

            $table->foreign('id_projet', 'fk_membre_projet_projet')
                  ->references('id_projet')
                  ->on('projet')
                  ->onDelete('cascade');

            $table->foreign('id_utilisateur', 'fk_membre_projet_users')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membre_projet');
    }
};
