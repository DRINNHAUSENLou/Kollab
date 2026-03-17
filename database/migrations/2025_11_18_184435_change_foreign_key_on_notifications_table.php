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
     Schema::table('notifications', function (Blueprint $table) {
        $table->dropForeign('notifications_ibfk_1');
    });

    Schema::table('notifications', function (Blueprint $table) {
        $table->integer('projet_id')->nullable()->change();
    });

    Schema::table('notifications', function (Blueprint $table) {
        $table->foreign('projet_id')
            ->references('id_projet')->on('projet')
            ->onDelete('set null');
    });
    }

    public function down(): void
    {
    Schema::table('notifications', function (Blueprint $table) {
        $table->dropForeign('notifications_projet_id_foreign');
    });

    Schema::table('notifications', function (Blueprint $table) {
        $table->integer('projet_id')->nullable(false)->change();
    });

    Schema::table('notifications', function (Blueprint $table) {
        $table->foreign('projet_id', 'notifications_ibfk_1')
            ->references('id_projet')->on('projet')
            ->onDelete('cascade');
    });
    }
};
