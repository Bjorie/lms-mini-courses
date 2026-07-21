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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('slug');

            $table->unique([
                'section_id',
                'slug',
            ]);

            $table->longText('content')->nullable();

            $table->string('video_url')
                ->nullable();

            $table->unsignedInteger('duration')
                ->default(0)
                ->comment('Продолжительность в секундах');

            $table->unsignedInteger('position')
                ->default(1);

            $table->boolean('is_free')
                ->default(false);

            $table->timestamps();

            $table->index(['section_id', 'position']);
            
            $table->timestamp('published_at')->nullable();

            $table->boolean('is_published')
                ->default(false);

            $table->enum('type', [
                'video',
                'article',
                'quiz',
                'assignment',
            ])->default('video');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
