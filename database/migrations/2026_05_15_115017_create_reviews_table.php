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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->morphs('reviewable');

            $table->tinyInteger('rating')
                ->unsigned()
                ->comment('Рейтинг от 1 до 5');

            $table->text('comment')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->index();

            $table->timestamps();

            $table->index(['reviewable_type', 'reviewable_id', 'status'], 'idx_reviewable_status');
            $table->index(['user_id', 'status'], 'idx_user_status');

            // Уникальность: один отзыв от пользователя на одну сущность
            $table->unique(
                ['user_id', 'reviewable_type', 'reviewable_id'],
                'unique_user_review'
            );
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
