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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('type'); // text, textarea, select, radio, checkbox, email, number, date, etc.
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->text('options')->nullable(); // JSON array for select, radio, checkbox options
            $table->boolean('required')->default(false);
            $table->text('validation_rules')->nullable(); // JSON array of Laravel validation rules
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
