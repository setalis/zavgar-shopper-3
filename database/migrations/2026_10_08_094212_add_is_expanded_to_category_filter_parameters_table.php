<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('category_filter_parameters', function (Blueprint $table): void {
            $table->boolean('is_expanded')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('category_filter_parameters', function (Blueprint $table): void {
            $table->dropColumn('is_expanded');
        });
    }
};
