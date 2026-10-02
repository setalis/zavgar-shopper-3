<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Support\MapVariantOptions;
use Illuminate\Support\Str;
use Shopper\Core\Macros\Arr;
use Shopper\Livewire\SlideOvers\GenerateVariants as BaseGenerateVariants;

final class GenerateVariants extends BaseGenerateVariants
{
    public function setupProductAttributes(): void
    {
        $this->availableOptions = MapVariantOptions::generate($this->product);

        if ($this->availableOptions === []) {
            $this->variants = [];

            return;
        }

        $this->mapVariantPermutations();
    }

    /**
     * Shopper wraps single-option permutations a second time, which leaves variants without names and values.
     *
     * @param  array<array-key, mixed>  $options
     * @param  array<array-key, mixed>  $variants
     * @return list<array<string, mixed>>
     */
    protected function mapVariantsToProductOptions(array $options, array $variants): array
    {
        $variantPermutations = [];

        foreach (Arr::permutate($options) as $permutation) {
            $variantIndex = collect($variants)->search(function (array $variant) use ($permutation): bool {
                $valueDifference = Arr::recursiveArrayDiffAssoc($permutation, $variant['values']);

                if ($valueDifference === []) {
                    return true;
                }

                return count($permutation) - count($valueDifference) === count($variant['values']);
            });

            $variant = $variantIndex === false ? null : $variants[$variantIndex];
            $isTaken = $variant !== null && collect($variantPermutations)->contains('variant_id', $variant['id']);

            $sku = $isTaken ? null : $variant['sku'] ?? null;

            if ($sku === null) {
                $variantSlug = mb_strtoupper(Str::slug(Arr::performPermutationIntoWord($permutation, 'value', '-')));
                $sku = $this->product->sku ? "{$this->product->sku}-{$variantSlug}" : $variantSlug;
            }

            $variantPermutations[] = [
                'key' => Str::random(),
                'variant_id' => $isTaken ? null : $variant['id'] ?? null,
                'name' => Arr::performPermutationIntoWord($permutation, 'value'),
                'sku' => $sku,
                'price' => $isTaken ? 0 : $variant['price'] ?? 0,
                'stock' => $isTaken ? 0 : $variant['stock'] ?? 0,
                'values' => Arr::getPermutationIds($permutation),
            ];
        }

        return $variantPermutations;
    }
}
