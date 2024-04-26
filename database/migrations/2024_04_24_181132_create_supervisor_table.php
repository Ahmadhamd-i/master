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
            $table->integer('ID', false)->unique('id');
            $table->string('Full_Name');
            $table->string('Password');
            $table->binary('Image')->default('NULL');
            $table->string('Email')->unique('email');
            $table->integer('Phone');
            $table->string('Address');
            $table->string('location');
            $table->rememberToken();
            $table->timestamps();

            /* $table->primary(['ID']); */
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
