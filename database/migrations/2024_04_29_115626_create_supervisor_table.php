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
        Schema::create('supervisor', function (Blueprint $table) {
            $table->id('ID', true)->unique('id');
            $table->string('Full_Name');
            $table->string('Password');
            $table->binary('Image')->nullable()->default(NULL);
            $table->string('Email');
            $table->string('Phone');
            $table->string('Address');
            $table->string('location')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor');
    }
};
