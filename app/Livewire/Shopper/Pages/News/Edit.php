<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\News;

use App\Enums\NewsPermission;
use App\Models\NewsArticle;
use App\Support\CatalogEnglishFields;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Shopper\Components\Section;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Shopper\Traits\HandlesAuthorizationExceptions;
use Throwable;
use Tiptap\Editor as TiptapEditor;

/**
 * @property-read Schema $form
 */
final class Edit extends AbstractPageComponent implements HasActions, HasSchemas
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;

    public NewsArticle $article;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(?NewsArticle $article = null): void
    {
        if ($article instanceof NewsArticle && $article->exists) {
            $this->authorize(NewsPermission::Edit->value);
            $this->article = $article;
            $this->form->fill([
                ...$article->attributesToArray(),
                'english' => $article->catalogTranslationPayload('en'),
            ]);

            return;
        }

        $this->authorize(NewsPermission::Create->value);
        $this->article = new NewsArticle;
        $this->form->fill([
            'is_enabled' => true,
            'published_at' => now(),
        ]);
    }

    public function exception(Throwable $e, callable $stopPropagation): void
    {
        if (! $e instanceof AuthorizationException) {
            return;
        }

        Notification::make()
            ->title(__('shopper::notifications.unauthorized.title'))
            ->body($e->getMessage() ?: __('shopper::notifications.unauthorized.body'))
            ->warning()
            ->send();

        $stopPropagation();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make(__('backend.news.single'))
                            ->compact()
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('backend.news.title'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (mixed $state, callable $set, callable $get): void {
                                        if (filled($get('slug'))) {
                                            return;
                                        }

                                        $set('slug', str((string) $state)->slug()->toString());
                                    }),
                                TextInput::make('slug')
                                    ->label(__('backend.news.slug'))
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Textarea::make('summary')
                                    ->label(__('backend.news.summary'))
                                    ->rows(3)
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->label(__('backend.news.description'))
                                    ->columnSpanFull(),
                                TextInput::make('seo_title')
                                    ->label(__('backend.news.seo_title'))
                                    ->maxLength(255),
                                Textarea::make('seo_description')
                                    ->label(__('backend.news.seo_description'))
                                    ->rows(3)
                                    ->columnSpanFull(),
                                CatalogEnglishFields::section(
                                    ['title', 'summary', 'description', 'seo_title', 'seo_description'],
                                ),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make(__('backend.news.publishing'))
                            ->compact()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->label(__('backend.news.cover'))
                                    ->collection(NewsArticle::MEDIA_THUMBNAIL)
                                    ->image()
                                    ->maxSize(config('shopper.media.max_size.thumbnail')),
                                DateTimePicker::make('published_at')
                                    ->label(__('backend.news.published_at'))
                                    ->native(false)
                                    ->seconds(false),
                                Toggle::make('is_enabled')
                                    ->label(__('backend.news.visibility'))
                                    ->default(true),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3)
            ->statePath('data')
            ->model($this->article);
    }

    public function store(): void
    {
        $creating = ! $this->article->exists;

        $this->authorize($creating ? NewsPermission::Create->value : NewsPermission::Edit->value);

        $english = $this->englishPayload();
        $data = $this->payload(CatalogEnglishFields::withoutEnglish($this->form->getState()));

        if ($creating) {
            $this->article = NewsArticle::create($data);
            $this->form->model($this->article)->saveRelationships();
            $this->article->saveCatalogTranslation('en', $english);

            Notification::make()
                ->title(__('backend.news.created'))
                ->success()
                ->send();

            $this->redirect(route('shopper.news.edit', ['article' => $this->article]), navigate: true);

            return;
        }

        $this->article->update($data);
        $this->article->saveCatalogTranslation('en', $english);

        Notification::make()
            ->title(__('backend.news.updated'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.news.edit')
            ->title(
                $this->article->exists
                    ? __('backend.news.edit')
                    : __('backend.news.create'),
            );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        $title = (string) ($data['title'] ?? '');
        $slug = isset($data['slug']) ? str((string) $data['slug'])->slug()->toString() : '';

        if ($slug === '') {
            $slug = str($title)->slug()->toString();
        }

        $data['slug'] = $this->uniqueSlug($slug === '' ? 'news' : $slug);
        unset($data['thumbnail'], $data['english']);

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function englishPayload(): array
    {
        $english = is_array($this->data['english'] ?? null) ? $this->data['english'] : [];

        if (is_array($english['description'] ?? null)) {
            $english['description'] = (new TiptapEditor)->setContent($english['description'])->getHTML();
        }

        return $english;
    }

    private function uniqueSlug(string $base): string
    {
        $candidate = $base;
        $suffix = 2;

        while (NewsArticle::query()
            ->where('slug', $candidate)
            ->when(
                $this->article->exists,
                fn (Builder $query): Builder => $query->where('id', '!=', $this->article->id),
            )
            ->exists()) {
            $candidate = $base.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }
}
