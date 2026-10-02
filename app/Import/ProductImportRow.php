<?php

declare(strict_types=1);

namespace App\Import;

use Shopper\Core\Import\ProductRow;

final readonly class ProductImportRow
{
    /**
     * @param  array<string, list<string>>  $attributes
     * @param  array<string, mixed>  $productData
     * @param  array<string, array<string, mixed>>  $variantData  Keyed by variant SKU.
     */
    public function __construct(
        public ProductRow $product,
        public array $attributes = [],
        public ?string $supplier = null,
        public array $productData = [],
        public array $variantData = [],
    ) {}

    public function withProduct(ProductRow $product): self
    {
        return new self(
            product: $product,
            attributes: $this->attributes,
            supplier: $this->supplier,
            productData: $this->productData,
            variantData: $this->variantData,
        );
    }
}
