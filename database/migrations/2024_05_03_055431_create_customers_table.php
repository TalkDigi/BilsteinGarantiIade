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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('CustomerID')->nullable();
            $table->string('No')->index();
            $table->string('Name')->nullable();
            $table->string('Name2')->nullable();
            $table->string('SearchName')->nullable();
            $table->string('Address')->nullable();
            $table->string('Currency')->nullable();
            $table->string('Balance')->nullable();
            $table->string('Status')->nullable();
            $table->string('token')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
