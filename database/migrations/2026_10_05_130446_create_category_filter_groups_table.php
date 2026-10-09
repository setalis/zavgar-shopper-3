<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_filter_groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained(shopper_table('categories'))->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'position']);
        });

        Schema::create('category_filter_parameters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('group_id')->constrained('category_filter_groups')->cascadeOnDelete();
            $table->string('type');
            $table->foreignId('attribute_id')->nullable()->constrained(shopper_table('attributes'))->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['group_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_filter_parameters');
        Schema::dropIfExists('category_filter_groups');
    }
};
