<?php

declare(strict_types=1);

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class BundleComponentData
{
    public function __construct(
        public int $productId,
        public ?int $variantId,
        public string $name,
        public ?string $variantName,
        public ?string $slug,
        public ?string $sku,
        public ?string $thumbnail,
        public int $quantity,
        public ?int $unitAmount,
        public bool $isAvailable,
    ) {}
}
