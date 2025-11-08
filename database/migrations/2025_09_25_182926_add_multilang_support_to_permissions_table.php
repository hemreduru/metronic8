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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('description_tr')->nullable()->after('description');
            $table->string('description_en')->nullable()->after('description_tr');

            // Mevcut description sütununu kaldırabiliriz veya genel olarak bırakabiliriz
            // Bu migration'da eski description'ları koruyalım
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['description_tr', 'description_en']);
        });
    }
};
