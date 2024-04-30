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
            $table->id('ID', true);
            $table->string('Full_Name')->unique('username');
            $table->string('Password');
            $table->string('Child_Name')->index('child_name');
            $table->string('Email')->unique('email');
            $table->integer('Phone')->unique('phone');
            $table->string('address')->unique('address');
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
