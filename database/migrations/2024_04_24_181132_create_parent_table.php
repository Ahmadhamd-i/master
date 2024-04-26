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
        Schema::create('parent', function (Blueprint $table) {
            $table->integer('ID', false)->unique('id');
            $table->string('Full_Name');
            $table->string('Password');
            $table->string('Child_Name')->index('child_name');
            $table->string('Email')->unique('email');
            $table->integer('Phone')->unique('phone');
            $table->string('address');
            $table->integer('Supervisor_ID');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent');
    }
};
