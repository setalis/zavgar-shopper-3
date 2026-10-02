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
     * @param  ?string  $sku  Product SKU that identifies the product between imports.
     */
    public function __construct(
        public ProductRow $product,
        public array $attributes = [],
        public ?string $supplier = null,
        public array $productData = [],
        public array $variantData = [],
        public ?string $sku = null,
    ) {}

    public function withProduct(ProductRow $product): self
    {
        return new self(
            product: $product,
            attributes: $this->attributes,
            supplier: $this->supplier,
            productData: $this->productData,
            variantData: $this->variantData,
            sku: $this->sku,
        );
    }

    public function withHandle(string $handle): self
    {
        $row = $this->product;

        return $this->withProduct(new ProductRow(
            handle: $handle,
            name: $row->name,
            description: $row->description,
            brand: $row->brand,
            categories: $row->categories,
            tags: $row->tags,
            published: $row->published,
            seoTitle: $row->seoTitle,
            seoDescription: $row->seoDescription,
            optionNames: $row->optionNames,
            variants: $row->variants,
            images: $row->images,
        ));
    }
}
