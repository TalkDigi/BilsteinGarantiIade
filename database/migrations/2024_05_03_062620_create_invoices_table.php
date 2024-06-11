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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('InvoiceNo')->nullable();
            $table->string('CustNo')->nullable();
            $table->string('Branch')->nullable();
            $table->string('PostingDate')->nullable();
            $table->string('ExDocNo')->nullable();
            $table->string('Amt')->nullable();
            $table->string('AmtIncVAT')->nullable();
            $table->json('Line')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
