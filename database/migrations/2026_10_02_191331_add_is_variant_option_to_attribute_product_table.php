<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $attributeProduct = shopper_table('attribute_product');

        Schema::table($attributeProduct, function (Blueprint $table): void {
            $table->boolean('is_variant_option')->default(false)->after('attribute_custom_value');
        });

        $variantValues = shopper_table('attribute_value_product_variant');
        $variants = shopper_table('product_variants');
        $values = shopper_table('attribute_values');

        // Attributes already used by a product's variants keep working as variant options.
        DB::table($attributeProduct)
            ->whereExists(fn (Builder $query): Builder => $query
                ->selectRaw('1')
                ->from($variantValues)
                ->join($variants, "{$variants}.id", '=', "{$variantValues}.variant_id")
                ->join($values, "{$values}.id", '=', "{$variantValues}.value_id")
                ->whereColumn("{$variants}.product_id", "{$attributeProduct}.product_id")
                ->whereColumn("{$values}.attribute_id", "{$attributeProduct}.attribute_id"))
            ->update(['is_variant_option' => true]);
    }

    public function down(): void
    {
        Schema::table(shopper_table('attribute_product'), function (Blueprint $table): void {
            $table->dropColumn('is_variant_option');
        });
    }
};
