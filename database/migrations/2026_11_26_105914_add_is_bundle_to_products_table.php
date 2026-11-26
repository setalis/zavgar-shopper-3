<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(shopper_table('products'), function (Blueprint $table): void {
            $table->boolean('is_bundle')->default(false)->after('type')->index();
        });
    }

    public function down(): void
    {
        Schema::table(shopper_table('products'), function (Blueprint $table): void {
            $table->dropIndex(['is_bundle']);
            $table->dropColumn('is_bundle');
        });
    }
};
