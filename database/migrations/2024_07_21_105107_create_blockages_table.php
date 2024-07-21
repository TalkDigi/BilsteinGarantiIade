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
        Schema::create('blockages', function (Blueprint $table) {
            $table->id();
            //InvoiceNo, is related to Invoice Model and InvoiceNo column
            $table->string('InvoiceNo');
            $table->string('ClaimNo');
            $table->string('ItemNo');
            $table->bigInteger('Qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blockages');
    }
};
