<?php

declare(strict_types=1);

namespace App\Import;

final class ProductImportTemplate
{
    public const array COLUMNS = [
        'handle',
        'name',
        'description',
        'brand',
        'category',
        'tags',
        'published',
        'featured',
        'supplier',
        'attributes',
        'variations',
        'sku',
        'barcode',
        'ean',
        'upc',
        'price',
        'compare_at_price',
        'cost_per_item',
        'currency',
        'quantity',
        'allow_backorder',
        'weight_value',
        'weight_unit',
        'width_value',
        'height_value',
        'depth_value',
        'length_unit',
        'image_url',
        'image_alt',
        'variant_image_url',
        'seo_title',
        'seo_description',
    ];

    /**
     * @return list<list<string>>
     */
    public function rows(): array
    {
        return [
            self::COLUMNS,
            ...array_map($this->row(...), $this->examples()),
        ];
    }

    /**
     * @param  array<string, string>  $values
     * @return list<string>
     */
    private function row(array $values): array
    {
        return array_map(fn (string $column): string => $values[$column] ?? '', self::COLUMNS);
    }

    /**
     * @return list<array<string, string>>
     */
    private function examples(): array
    {
        return [
            [
                'handle' => 'futbolka-bazova',
                'name' => 'Футболка базова',
                'description' => 'М\'яка бавовняна футболка прямого крою.',
                'brand' => 'Acme',
                'category' => 'Одяг > Футболки',
                'tags' => 'Унісекс, Бавовна',
                'published' => '1',
                'featured' => '1',
                'supplier' => 'ТОВ Текстиль',
                'attributes' => 'Матеріал: Бавовна | Еластан; Країна виробництва: Україна',
                'sku' => 'TS-BASE',
                'image_url' => 'https://example.com/images/futbolka.jpg',
                'image_alt' => 'Футболка базова',
                'seo_title' => 'Футболка базова з бавовни',
                'seo_description' => 'М\'яка бавовняна футболка прямого крою.',
            ],
            [
                'variations' => 'Розмір: M; Колір: Синій',
                'sku' => 'TS-M-BLUE',
                'barcode' => '4820000000011',
                'price' => '499',
                'compare_at_price' => '599',
                'cost_per_item' => '250',
                'quantity' => '10',
                'allow_backorder' => '0',
                'weight_value' => '180',
                'weight_unit' => 'g',
                'width_value' => '30',
                'height_value' => '2',
                'depth_value' => '40',
                'length_unit' => 'cm',
                'variant_image_url' => 'https://example.com/images/futbolka-blue.jpg',
            ],
            [
                'variations' => 'Розмір: L; Колір: Синій',
                'sku' => 'TS-L-BLUE',
                'barcode' => '4820000000028',
                'price' => '499',
                'compare_at_price' => '599',
                'cost_per_item' => '250',
                'quantity' => '5',
                'allow_backorder' => '0',
                'weight_value' => '200',
                'weight_unit' => 'g',
                'width_value' => '32',
                'height_value' => '2',
                'depth_value' => '42',
                'length_unit' => 'cm',
                'variant_image_url' => 'https://example.com/images/futbolka-blue.jpg',
            ],
            [
                'variations' => 'Розмір: L; Колір: Червоний',
                'sku' => 'TS-L-RED',
                'barcode' => '4820000000035',
                'price' => '529',
                'cost_per_item' => '260',
                'quantity' => '0',
                'allow_backorder' => '1',
                'weight_value' => '200',
                'weight_unit' => 'g',
                'variant_image_url' => 'https://example.com/images/futbolka-red.jpg',
            ],
            [
                'handle' => 'parfum-klasychnyi',
                'name' => 'Парфум класичний',
                'description' => 'Позачасовий аромат з нотами кедра та цитрусових.',
                'brand' => 'Acme',
                'category' => 'Краса > Парфуми',
                'tags' => 'Парфуми, Подарунок',
                'published' => '1',
                'featured' => '0',
                'attributes' => 'Об\'єм: 50 мл; Тип аромату: Деревний',
                'sku' => 'PF-50',
                'barcode' => '4820000000042',
                'price' => '1299',
                'compare_at_price' => '1499',
                'quantity' => '20',
                'allow_backorder' => '0',
                'weight_value' => '0,3',
                'weight_unit' => 'kg',
                'width_value' => '6',
                'height_value' => '12',
                'depth_value' => '4',
                'length_unit' => 'cm',
                'image_url' => 'https://example.com/images/parfum.jpg',
                'image_alt' => 'Флакон парфуму',
                'seo_title' => 'Парфум класичний 50 мл',
                'seo_description' => 'Позачасовий аромат з нотами кедра та цитрусових.',
            ],
        ];
    }
}
