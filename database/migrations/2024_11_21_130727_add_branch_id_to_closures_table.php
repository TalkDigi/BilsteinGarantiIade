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
            $table->integer('BranchNo')->default(null)->after('CustNo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closures', function (Blueprint $table) {
            //
            $table->dropColumn('BranchNo');
        });
    }
};
