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
        Schema::create('checkup_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkup_id')->constrained();
            $table->foreignId('medicine_id')->constrained();
            $table->integer('qty');
            $table->string('unit');
            $table->string('dosis');
            $table->string('duration');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_medicines');
    }
};
