<?php

declare(strict_types=1);

namespace App\DTO;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class BundleCompositionData
{
    /**
     * @param  list<BundleComponentData>  $items
     */
    public function __construct(
        public array $items,
        public ?int $componentsTotal,
        public ?int $bundleAmount,
        public ?int $savings,
        public int $stock,
    ) {}
}
