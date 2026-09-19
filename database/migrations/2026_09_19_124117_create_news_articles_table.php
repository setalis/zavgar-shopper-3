<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->boolean('is_enabled')->default(true)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();

            $table->index(['is_enabled', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
