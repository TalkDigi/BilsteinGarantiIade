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
        Schema::create('statuses', function (Blueprint $table) {

            $table->id();
            $table->boolean('status')->default(true);
            $table->string('html')->nullable()->default(null);
            $table->string('slug')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
            $table->boolean('hasNotes')->nullable()->default(false);
            $table->boolean('noteRequired')->nullable()->default(false);
            $table->boolean('canEdit')->nullable()->default(false);
            $table->boolean('showShipment')->nullable()->default(false);
            $table->boolean('canInvoice')->nullable()->default(false);
            $table->boolean('deleteBlocked')->nullable()->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
