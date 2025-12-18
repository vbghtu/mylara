<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // === Основные категории ===
            ['name' => 'Украшения', 'parent_name' => null],
            ['name' => 'Бижутерия', 'parent_name' => null],
            ['name' => 'Одежда', 'parent_name' => null],
            ['name' => 'Для дома', 'parent_name' => null],
            ['name' => 'Детские товары', 'parent_name' => null],
            ['name' => 'Игрушки', 'parent_name' => null],
            ['name' => 'Куклы', 'parent_name' => null],
            ['name' => 'Текстиль', 'parent_name' => null],
            ['name' => 'Керамика и фарфор', 'parent_name' => null],
            ['name' => 'Кожа и мех', 'parent_name' => null],
            ['name' => 'Предметы интерьера', 'parent_name' => null],
            ['name' => 'Для животных', 'parent_name' => null],
            ['name' => 'Флористика', 'parent_name' => null],
            ['name' => 'Художественное творчество', 'parent_name' => null],

            // === Подкатегории: Украшения ===
            ['name' => 'Серьги', 'parent_name' => 'Украшения'],
            ['name' => 'Кольца', 'parent_name' => 'Украшения'],
            ['name' => 'Кулоны и подвески', 'parent_name' => 'Украшения'],
            ['name' => 'Браслеты', 'parent_name' => 'Украшения'],
            ['name' => 'Цепочки и шнуры', 'parent_name' => 'Украшения'],
            ['name' => 'Комплекты', 'parent_name' => 'Украшения'],
            ['name' => 'Броши и значки', 'parent_name' => 'Украшения'],
            ['name' => 'Для волос', 'parent_name' => 'Украшения'],

            // === Подкатегории: Бижутерия ===
            ['name' => 'Серьги-гвоздики', 'parent_name' => 'Бижутерия'],
            ['name' => 'Колье', 'parent_name' => 'Бижутерия'],
            ['name' => 'Обручи и заколки', 'parent_name' => 'Бижутерия'],

            // === Подкатегории: Одежда ===
            ['name' => 'Платья', 'parent_name' => 'Одежда'],
            ['name' => 'Костюмы', 'parent_name' => 'Одежда'],
            ['name' => 'Верхняя одежда', 'parent_name' => 'Одежда'],
            ['name' => 'Головные уборы', 'parent_name' => 'Одежда'],
            ['name' => 'Перчатки и варежки', 'parent_name' => 'Одежда'],
            ['name' => 'Носки и гетры', 'parent_name' => 'Одежда'],

            // === Подкategorии: Для дома ===
            ['name' => 'Посуда', 'parent_name' => 'Для дома'],
            ['name' => 'Декор', 'parent_name' => 'Для дома'],
            ['name' => 'Свечи и подсвечники', 'parent_name' => 'Для дома'],
            ['name' => 'Ковры и дорожки', 'parent_name' => 'Для дома'],
            ['name' => 'Часы', 'parent_name' => 'Для дома'],

            // === Подкатегории: Детские товары ===
            ['name' => 'Одежда для детей', 'parent_name' => 'Детские товары'],
            ['name' => 'Обувь для детей', 'parent_name' => 'Детские товары'],
            ['name' => 'Аксессуары для детей', 'parent_name' => 'Детские товары'],
            ['name' => 'Для новорожденных', 'parent_name' => 'Детские товары'],

            // === Подкатегории: Игрушки ===
            ['name' => 'Мягкие игрушки', 'parent_name' => 'Игрушки'],
            ['name' => 'Развивающие игрушки', 'parent_name' => 'Игрушки'],
            ['name' => 'Игрушки ручной работы', 'parent_name' => 'Игрушки'],
            ['name' => 'Амигуруми', 'parent_name' => 'Игрушки'],

            // === Подкатегории: Куклы ===
            ['name' => 'Текстильные куклы', 'parent_name' => 'Куклы'],
            ['name' => 'Фарфоровые куклы', 'parent_name' => 'Куклы'],
            ['name' => 'Авторские куклы', 'parent_name' => 'Куклы'],

            // === Подкатегории: Текстиль ===
            ['name' => 'Постельное бельё', 'parent_name' => 'Текстиль'],
            ['name' => 'Полотенца', 'parent_name' => 'Текстиль'],
            ['name' => 'Скатерти и салфетки', 'parent_name' => 'Текстиль'],

            // === Подкатегории: Керамика и фарфор ===
            ['name' => 'Чайные сервизы', 'parent_name' => 'Керамика и фарфор'],
            ['name' => 'Вазы', 'parent_name' => 'Керамика и фарфор'],
            ['name' => 'Статуэтки', 'parent_name' => 'Керамика и фарфор'],

            // === Подкатегории: Предметы интерьера ===
            ['name' => 'Зеркала', 'parent_name' => 'Предметы интерьера'],
            ['name' => 'Картины', 'parent_name' => 'Предметы интерьера'],
            ['name' => 'Панно', 'parent_name' => 'Предметы интерьера'],

        ];

        $categories = [];
        foreach ($data as $item) {
            $category = Category::updateOrCreate([
                'name' => $item['name'],
                'slug' => Str::slug($item['name'], '-', 'ru'),
                'parent_id' => null, // временно
            ]);
            $categories[$item['name']] = $category->id;
        }

        // Теперь обновляем parent_id
        foreach ($data as $item) {
            if ($item['parent_name']) {
                $parentId = $categories[$item['parent_name']] ?? null;
                Category::where('name', $item['name'])->update(['parent_id' => $parentId]);
            }
        }
    }
}
