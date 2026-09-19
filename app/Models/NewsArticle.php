<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCatalogTranslations;
use App\Concerns\InteractsWithStorefrontMedia;
use Database\Factories\NewsArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopper\Models\Traits\HasMedia;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;

final class NewsArticle extends Model implements SpatieHasMedia
{
    use HasCatalogTranslations;

    /** @use HasFactory<NewsArticleFactory> */
    use HasFactory;

    use HasMedia;
    use InteractsWithStorefrontMedia;

    public const string MEDIA_THUMBNAIL = 'thumbnail';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'seo_title',
        'seo_description',
        'is_enabled',
        'published_at',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_enabled' => true,
    ];

    public function registerMediaCollections(): void
    {
        $disk = (string) config('shopper.media.storage.disk_name', 'public');
        $mimeTypes = config('shopper.media.accepts_mime_types', []);

        $this->addMediaCollection(self::MEDIA_THUMBNAIL)
            ->useDisk($disk)
            ->singleFile()
            ->acceptsMimeTypes($mimeTypes);
    }

    /**
     * @return array<string, string>
     */
    public function catalogTranslationMap(): array
    {
        return [
            'title' => 'name',
            'summary' => 'summary',
            'description' => 'description',
            'seo_title' => 'seo_title',
            'seo_description' => 'seo_description',
        ];
    }

    public function isPublished(): bool
    {
        return $this->is_enabled
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query
            ->where('is_enabled', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
