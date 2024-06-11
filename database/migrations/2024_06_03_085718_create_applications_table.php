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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->integer('editable')->default(0);
            $table->string('type');
            $table->string('invoice');
            $table->json('quantities');
            $table->json('application');
            $table->json('files');
            $table->integer('version')->default(1);
            $table->foreignId('rejected_by')->constrained('users')->nullable();
            //hold user_id for creator
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
