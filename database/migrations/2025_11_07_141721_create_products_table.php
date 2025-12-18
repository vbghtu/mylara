<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');

            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true);

            $table->string('material')->nullable();
            $table->boolean('is_customizable')->default(false);
            $table->string('image_path')->nullable(); // если используешь один файл

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Сначала удаляем внешние ключи
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
        });
        
        Schema::dropIfExists('products');
    }
};
