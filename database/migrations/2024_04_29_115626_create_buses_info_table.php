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
        Schema::create('buses_info', function (Blueprint $table) {
            $table->id('ID', true);
            $table->string('Bus_Line_Name');
            $table->string('Bus_License');

            // $table->primary(['Bus_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses_info');
    }
};
