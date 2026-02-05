<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ru_RU');

        $userIds = DB::table('users')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        if (empty($userIds) || empty($categoryIds)) {
            $this->command->error('Нет пользователей или категорий в базе данных!');
            return;
        }

        // Создаём директории для изображений
        $this->command->info('Создаём директории для изображений...');

        $productsDir = storage_path('app/public/products');
        $galleryDir = storage_path('app/public/products/gallery');

        if (!is_dir($productsDir)) {
            mkdir($productsDir, 0755, true);
        }

        if (!is_dir($galleryDir)) {
            mkdir($galleryDir, 0755, true);
        }

        $productTitles = [
            'Вязаный шарф',
            'Плед ручной работы',
            'Шапка спицами',
            'Мыло ручной работы',
            'Ароматическая свеча',
            'Деревянная шкатулка',
            'Керамическая кружка',
            'Вышитая подушка',
            'Браслет ручной работы',
            'Сумка из льна',
            'Картина маслом',
            'Вязаные носки',
            'Свеча в стекле',
            'Деревянная разделочная доска',
            'Керамическая ваза',
            'Вышитое панно',
            'Серьги из бисера',
            'Клатч из кожи',
            'Акварельная зарисовка',
            'Вязаное одеяло',
            'Деревянная ложка',
            'Керамическая тарелка',
            'Кольцо ручной работы',
            'Сумка-тоут',
            'Вязаные варежки',
            'Деревянная рамка',
            'Керамическое кашпо',
            'Бусы из натуральных камней',
            'Кошелек из кожи',
            'Абстрактная картина'
        ];

        $materials = [
            'натуральная шерсть',
            'хлопок',
            'лен',
            'акрил',
            'шелк',
            'дерево дуб',
            'керамика',
            'глина',
            'стекло',
            'латунь',
            'натуральная кожа',
            'замша',
            'фетр',
            'чешский бисер',
            'нитки мулине',
            'вощеный шнур',
            'аметист',
            'эпоксидная смола'
        ];

        $this->command->info('Начинаем создание товаров с изображениями...');

        foreach (range(1, 50) as $index) {
            $title = $faker->randomElement($productTitles) . ' ' . $faker->colorName();
            $slug = str($title)->slug() . '-' . $faker->unique()->numberBetween(1000, 9999);
            $userId = $faker->randomElement($userIds);
            $categoryId = $faker->randomElement($categoryIds);
            $material = $faker->randomElement($materials);

            // Генерируем путь для скачивания
            $imageSeed = 'product_' . $slug . '_' . uniqid();
            $imageUrl = "https://picsum.photos/seed/{$imageSeed}/600/400";

            // Скачиваем главное изображение
            $mainImageFilename = 'product_' . $index . '_' . uniqid() . '.jpg';
            $mainImagePath = $productsDir . '/' . $mainImageFilename;

            try {
                $imageContent = file_get_contents($imageUrl);
                if ($imageContent !== false) {
                    file_put_contents($mainImagePath, $imageContent);
                    $dbImagePath = 'products/' . $mainImageFilename;
                } else {
                    // Если не удалось скачать, используем заглушку
                    $dbImagePath = null;
                    $this->command->warn("⚠️ Не удалось скачать изображение для товара {$index}");
                }
            } catch (\Exception $e) {
                $dbImagePath = null;
                $this->command->warn("⚠️ Ошибка при скачивании изображения: " . $e->getMessage());
            }

            // Вставляем продукт
            $productId = DB::table('products')->insertGetId([
                'user_id' => $userId,
                'category_id' => $categoryId,
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->paragraphs($faker->numberBetween(2, 4), true),
                'price' => $faker->randomFloat(2, 300, 15000),
                'is_available' => $faker->boolean(90),
                'material' => $material,
                'is_customizable' => $faker->boolean(60),
                'image_path' => $dbImagePath,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);

            // Создаём галерею: 1-5 изображений
            $numImages = $faker->numberBetween(1, 5);
            $images = [];

            for ($i = 1; $i <= $numImages; $i++) {
                $gallerySeed = 'gallery_' . $productId . '_' . $i . '_' . uniqid();
                $galleryUrl = "https://picsum.photos/seed/{$gallerySeed}/800/600";

                $galleryFilename = 'gallery_' . $productId . '_' . $i . '_' . uniqid() . '.jpg';
                $galleryPath = $galleryDir . '/' . $galleryFilename;

                try {
                    $galleryContent = file_get_contents($galleryUrl);
                    if ($galleryContent !== false) {
                        file_put_contents($galleryPath, $galleryContent);
                        $dbGalleryPath = 'products/gallery/' . $galleryFilename;

                        $images[] = [
                            'product_id' => $productId,
                            'path' => $dbGalleryPath,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                } catch (\Exception $e) {
                    $this->command->warn("⚠️ Ошибка при скачивании галереи {$i} для товара {$productId}");
                }
            }

            // Вставляем изображения галереи
            if (!empty($images)) {
                DB::table('product_images')->insert($images);
            }

            if ($index % 10 === 0) {
                $this->command->info("✅ Создано {$index} товаров...");
            }
        }

        $this->command->info('✅ Сидер завершён! 50 товаров с изображениями.');
        $this->command->comment('Изображения сохранены в: ' . $productsDir);
        $this->command->comment('Галерея сохранена в: ' . $galleryDir);

        // Создаём символическую ссылку для доступа из публичной директории
        $this->command->info('Создаём символическую ссылку storage...');
        \Artisan::call('storage:link');
        $this->command->info('✅ Symbolic link created!');
    }
}
