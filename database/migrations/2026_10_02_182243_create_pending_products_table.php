<?php

declare(strict_types=1);

use App\Enums\PendingProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_products', function (Blueprint $table): void {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->foreignId('product_import_id')
                ->nullable()
                ->constrained(shopper_table('product_imports'))
                ->nullOnDelete();
            $table->longText('payload');
            $table->string('status')->default(PendingProductStatus::Pending->value)->index();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_products');
    }
};
