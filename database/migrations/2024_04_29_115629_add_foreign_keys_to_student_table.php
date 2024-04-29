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
        Schema::table('student', function (Blueprint $table) {
            $table->foreignId('Supervisor_ID')->constrained('supervisor');
            $table->foreignId('Parent_ID')->constrained('parent');
            /*  $table->foreign(['ID'], 'student_ibfk_3')->references(['student_ID'])->on('enrollment')->onUpdate('restrict')->onDelete('restrict'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
        });
    }
};
