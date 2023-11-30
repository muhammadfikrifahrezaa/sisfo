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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registration_number');
            $table->string('phone_number');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->enum('type_identity', ['KTP', 'SIM', 'Kartu Pelajar']);
            $table->string('no_identity')->unique();
            $table->string('blood_type');
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
