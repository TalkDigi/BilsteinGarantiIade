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
        Schema::table('quantities', function (Blueprint $table) {
            //
            $table->string('ItemNo')->default(null)->change();
            $table->string('unit')->default(null)->change();
            $table->string('file_id')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quantities_', function (Blueprint $table) {
            //
        });
    }
};
