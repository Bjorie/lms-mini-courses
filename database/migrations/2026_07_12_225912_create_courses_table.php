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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->text('short_description')
                ->nullable();

            $table->longText('description')
                ->nullable();

            $table->string('thumbnail')
                ->nullable();

            $table->decimal('price', 10, 2)
                ->default(0);

            $table->enum('level', [
                'beginner',
                'intermediate',
                'advanced'
            ]);

            $table->enum('status', [
                'draft',
                'review',
                'published',
                'archived'
            ])->default('draft');

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
