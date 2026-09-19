<?php

declare(strict_types=1);

return [

    'system' => [
        'dashboard' => [
            'display_name' => 'Доступ до панелі',
            'description' => 'Дозволяє користувачу відкривати адмінпанель.',
        ],
        'settings' => [
            'display_name' => 'Доступ до налаштувань',
            'description' => 'Дозволяє користувачу переглядати та керувати сторінками налаштувань.',
        ],
        'users' => [
            'display_name' => 'Перегляд користувачів',
            'description' => 'Дозволяє користувачу відкривати розділ команди та ролей.',
        ],
    ],

    'generate' => [
        'browse' => [
            'display_name' => 'Перегляд :item',
            'description' => 'Дозволяє переглядати всі записи :item із пошуком, фільтрами та пагінацією.',
        ],
        'read' => [
            'display_name' => 'Читання :item',
            'description' => 'Дозволяє переглядати повні деталі одного запису :item.',
        ],
        'edit' => [
            'display_name' => 'Редагування :item',
            'description' => 'Дозволяє редагувати та оновлювати наявний запис :item.',
        ],
        'create' => [
            'display_name' => 'Створення :item',
            'description' => 'Дозволяє створювати новий запис :item.',
        ],
        'delete' => [
            'display_name' => 'Видалення :item',
            'description' => 'Дозволяє остаточно видалити запис :item.',
        ],
    ],

];
