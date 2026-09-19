<?php

declare(strict_types=1);

return [
    'automatic' => 'Автоматична',
    'automatic_description' => 'Товари, що відповідають заданим умовам, автоматично додаються до колекції.',
    'manual' => 'Вручну',
    'manual_description' => 'Додавайте товари до цієї колекції по одному.',

    'rules' => [
        'product_title' => 'Назва товару',
        'product_brand' => 'Бренд товару',
        'product_category' => 'Категорія товару',
        'product_price' => 'Ціна товару',
        'compare_at_price' => 'Ціна для порівняння',
        'inventory_stock' => 'Запас на складі',
        'product_created_at' => 'Дата створення товару',
        'product_featured' => 'Рекомендований товар',
        'product_rating' => 'Рейтинг товару',
        'product_sales_count' => 'Кількість продажів товару',
    ],

    'operator' => [
        'equals_to' => 'Дорівнює',
        'not_equals_to' => 'Не дорівнює',
        'less_than' => 'Менше ніж',
        'greater_than' => 'Більше ніж',
        'starts_with' => 'Починається з',
        'ends_with' => 'Закінчується на',
        'contains' => 'Містить',
        'not_contains' => 'Не містить',
    ],
];
