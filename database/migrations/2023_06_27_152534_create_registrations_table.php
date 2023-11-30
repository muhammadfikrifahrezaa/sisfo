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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');
            $table->enum('type_visit', ['Kunjungan Sakit', 'Kunjungan Sehat']);
            $table->enum('type_treatment', ['Rawat Jalan', 'Rawat Inap']);
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('poli_id')->constrained();
            $table->date('consultation_date');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('doctor_schedule_id')->constrained();
            $table->enum('financing', ['Pribadi', 'Keluarga']);
            $table->string('status')->default('Dalam Antrian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
