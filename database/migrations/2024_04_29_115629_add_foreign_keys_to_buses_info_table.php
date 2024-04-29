<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lcobucci\JWT\Validation\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buses_info', function (Blueprint $table) {
            $table->foreignId('Bus_Supervisor_ID')->constrained('supervisor');
            $table->foreignId('Bus_Driver_ID')->constrained('driver');
            /* $table->foreign(['Bus_ID'], 'buses_info_ibfk_4')->references(['Bus_ID'])->on('enrollment')->onUpdate('restrict')->onDelete('restrict'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buses_info', function (Blueprint $table) {
        });
    }
};
