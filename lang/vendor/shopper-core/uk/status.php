<?php

declare(strict_types=1);

return [
    'archived' => 'Архівовано',
    'awaiting' => 'Очікує',
    'cancelled' => 'Скасовано',
    'completed' => 'Виконано',
    'new' => 'Нове',
    'not_paid' => 'Не оплачено',
    'not_refunded' => 'Не повернено',
    'partial-refund' => 'Частково повернено',
    'pending' => 'В очікуванні',
    'processing' => 'Обробляється',
    'treatment' => 'В обробці',
    'refunded' => 'Повернено',
    'rejected' => 'Відхилено',

    'payment' => [
        'pending' => 'Очікує оплати',
        'authorized' => 'Авторизовано',
        'paid' => 'Оплачено',
        'partially_refunded' => 'Частково повернено',
        'refunded' => 'Повернено',
        'voided' => 'Анульовано',
    ],

    'shipping' => [
        'unfulfilled' => 'Не відвантажено',
        'partially_shipped' => 'Частково відправлено',
        'shipped' => 'Відправлено',
        'partially_delivered' => 'Частково доставлено',
        'delivered' => 'Доставлено',
        'partially_returned' => 'Частково повернуто',
        'returned' => 'Повернено',
    ],

    'fulfillment' => [
        'pending' => 'Очікує комплектації',
        'forwarded' => 'Передано постачальнику',
        'processing' => 'Готується',
        'shipped' => 'Відправлено',
        'delivered' => 'Доставлено',
        'cancelled' => 'Скасовано',
    ],

    'shipment' => [
        'pending' => 'Етикетку створено',
        'picked_up' => 'Забрано',
        'in_transit' => 'У дорозі',
        'at_sorting_center' => 'У сортувальному центрі',
        'out_for_delivery' => 'Передано курʼєру',
        'delivered' => 'Доставлено',
        'delivery_failed' => 'Доставка не вдалася',
        'returned' => 'Повернено',
    ],

    'stock' => [
        'reserved' => 'Зарезервовано під замовлення',
        'cancelled' => 'Звільнено зі скасованого замовлення',
    ],

    'discount' => [
        'draft' => 'Чернетка',
        'scheduled' => 'Заплановано',
        'active' => 'Активна',
        'disabled' => 'Вимкнена',
        'expired' => 'Минула',
        'limit_reached' => 'Ліміт вичерпано',
        'inapplicable' => 'Не застосовується',
    ],

    'campaign' => [
        'draft' => 'Чернетка',
        'scheduled' => 'Заплановано',
        'active' => 'Активна',
        'disabled' => 'Вимкнена',
        'expired' => 'Минула',
        'budget_exhausted' => 'Бюджет вичерпано',
    ],
];
