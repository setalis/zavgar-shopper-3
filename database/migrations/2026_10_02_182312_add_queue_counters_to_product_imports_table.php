<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(shopper_table('product_imports'), function (Blueprint $table): void {
            $table->unsignedInteger('queued_count')->default(0)->after('imported_count');
            $table->unsignedInteger('skipped_count')->default(0)->after('queued_count');
        });
    }

    public function down(): void
    {
        Schema::table(shopper_table('product_imports'), function (Blueprint $table): void {
            $table->dropColumn(['queued_count', 'skipped_count']);
        });
    }
};
