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
        Schema::create('showcases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('slug')->unique()->nullable();
            $table->string('title');

            // Изображения
            $table->string('logo')->nullable(); // Логотип
            $table->string('banner')->nullable(); // Баннер/обложка

            // Платная подписка
            $table->boolean('is_active')->default(false); // Активна ли витрина
//            $table->enum('status', ['pending', 'active', 'suspended', 'expired'])->default('pending');
            $table->timestamp('subscription_start')->nullable(); // Начало подписки
            $table->timestamp('subscription_end')->nullable(); // Окончание подписки
//            $table->decimal('price', 10, 2)->nullable(); // Цена подписки
//            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Контакты
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
//            $table->json('social_links')->nullable(); // ['facebook' => '...', 'instagram' => '...']

            // Настройки
//            $table->string('theme')->default('default'); // Тема оформления
//            $table->json('settings')->nullable(); // Доп. настройки (цвета, макет и т.д.)

            // Аналитика
            $table->integer('views_count')->default(0); // Количество просмотров
//            $table->integer('products_count')->default(0); // Количество товаров

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('showcases', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
        });
        Schema::dropIfExists('showcases');
    }
};
