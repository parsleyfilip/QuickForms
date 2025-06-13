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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('theme_color')->default('#4F46E5');
            $table->string('background_color')->default('#FFFFFF');
            $table->string('button_color')->default('#4F46E5');
            $table->string('button_text_color')->default('#FFFFFF');
            $table->boolean('show_progress_bar')->default(true);
            $table->boolean('allow_multiple_responses')->default(true);
            $table->boolean('collect_email')->default(false);
            $table->boolean('require_email')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
