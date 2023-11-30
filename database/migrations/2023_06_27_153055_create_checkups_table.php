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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained();
            $table->text('main_complaint');
            $table->text('anamnesa');
            $table->float('body_temperature');
            $table->float('sistole');
            $table->float('diastole');
            $table->float('nadi');
            $table->float('respiratory_frequency');
            $table->float('head_circumference');
            $table->float('height');
            $table->float('weight');
            $table->float('imt');
            $table->string('conscious');
            $table->text('notes')->nullable();
            $table->text('diagnosis');
            $table->text('prognosa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
