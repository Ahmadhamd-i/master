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
        Schema::create('enrollment', function (Blueprint $table) {
            /* $table->integer('student_ID')->unique('student_id'); */
            $table->dateTime('enroll_time')->useCurrent();
            $table->boolean('Enroll_Status')->nullable();
            /* $table->integer('Bus_ID')->primary(); */
            $table->foreignId('Student_ID')->constrained('student');
            $table->foreignId('Bus_ID')->constrained('buses_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
