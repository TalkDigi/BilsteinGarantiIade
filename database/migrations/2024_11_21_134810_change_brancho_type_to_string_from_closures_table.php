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
        Schema::table('closures', function (Blueprint $table) {
            //
            $table->string('BranchNo')->default(null)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closures', function (Blueprint $table) {
            //
            $table->integer('BranchNo')->default(null)->nullable()->change();
        });
    }
};
