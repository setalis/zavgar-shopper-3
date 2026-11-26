<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_bundle_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('bundle_id')->constrained(shopper_table('products'))->cascadeOnDelete();
            $table->foreignId('product_id')->constrained(shopper_table('products'))->restrictOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained(shopper_table('product_variants'))->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['bundle_id', 'product_id', 'product_variant_id'], 'product_bundle_items_component_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_bundle_items');
    }
};
