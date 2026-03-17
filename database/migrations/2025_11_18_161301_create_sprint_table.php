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
        Schema::create('sprint', function (Blueprint $table) {
            $table->unsignedInteger('id_sprint')->autoIncrement();
            $table->string('nom', 255);
            $table->integer('id_projet')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->text('objectif')->nullable();

            $table->unique(['id_sprint', 'id_projet'], 'uq_sprint_projet');

            $table->foreign('id_projet', 'fk_sprint_projet')
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
        Schema::dropIfExists('sprint');
    }
};
