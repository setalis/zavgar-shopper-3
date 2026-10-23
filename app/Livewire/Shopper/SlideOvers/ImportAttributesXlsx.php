<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Import\AttributeImportException;
use App\Import\ImportsAttributeFile;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\View;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Components\SlideOverWizard;
use Shopper\Components\Wizard\StepColumn;
use Shopper\Core\Exceptions\ProductImportException;
use Shopper\Traits\HandlesAuthorizationExceptions;

/**
 * @property-read Schema $form
 */
final class ImportAttributesXlsx extends SlideOverComponent implements HasActions, HasSchemas
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;

    public const int PREVIEW_LIMIT = 50;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    /** @var array<string, mixed> */
    public array $preview = [];

    public static function panelMaxWidth(): string
    {
        return '4xl';
    }

    public function mount(): void
    {
        $this->authorize('attributes.create');

        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SlideOverWizard::make([
                    StepColumn::make(__('shopper::pages/products.import.steps.upload'))
                        ->icon(Untitledui::UploadCloud02)
                        ->schema([
                            FileUpload::make('file')
                                ->label(__('backend.attribute_imports.xlsx_file'))
                                ->helperText(__('backend.attribute_imports.xlsx_file_helper'))
                                ->required()
                                ->storeFiles(false)
                                ->acceptedFileTypes([
                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                ])
                                ->rules(['mimes:xlsx', 'extensions:xlsx'])
                                ->hintAction(
                                    Action::make('downloadTemplate')
                                        ->label(__('shopper::pages/products.import.download_template'))
                                        ->color('info')
                                        ->url(route('shopper.attributes.import-xlsx-template'), shouldOpenInNewTab: true),
                                ),
                        ])
                        ->afterValidation(function (): void {
                            $this->buildPreview();
                        }),
                    StepColumn::make(__('shopper::pages/products.import.steps.review'))
                        ->icon(Untitledui::CheckVerified02)
                        ->schema([
                            View::make('livewire.shopper.slide-overs.import-attributes-xlsx-preview'),
                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                        <x-filament::button type="submit" wire:loading.attr="disabled">
                            <x-shopper::loader wire:loading wire:target="store" class="text-white" />
                            {{ __('shopper::pages/products.import.submit') }}
                        </x-filament::button>
                     BLADE))),
            ])
            ->statePath('data');
    }

    public function store(ImportsAttributeFile $importer): void
    {
        $this->authorize('attributes.create');
        $this->validate();

        $file = $this->uploadedFile();

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        try {
            $result = $importer->handle((string) $file->getRealPath());
        } catch (AttributeImportException|ProductImportException $exception) {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();

            return;
        }

        $notification = Notification::make()
            ->title(__('backend.attribute_imports.import_completed', [
                'updated' => $result->updated,
                'queued' => $result->queued,
            ]));

        if ($result->errors === []) {
            $notification->success();
        } else {
            $notification
                ->body(__('backend.attribute_imports.import_failed', ['count' => count($result->errors)]))
                ->warning();
        }

        $notification->send();

        $this->dispatch('attributes.import.finished');
        $this->closePanel();
    }

    public function render(): ViewContract
    {
        return view('livewire.shopper.slide-overs.import-attributes-xlsx');
    }

    protected function buildPreview(): void
    {
        $file = $this->uploadedFile();

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        try {
            $result = resolve(ImportsAttributeFile::class)->inspect((string) $file->getRealPath());
        } catch (AttributeImportException|ProductImportException $exception) {
            throw ValidationException::withMessages([
                'data.file' => $exception->getMessage(),
            ]);
        }

        $this->preview = [
            'updated' => $result->updated,
            'queued' => $result->queued,
            'failed' => count($result->errors),
            'rows' => array_slice(
                array_values(array_filter($result->rows, fn (array $row): bool => $row['error'] === null)),
                0,
                self::PREVIEW_LIMIT,
            ),
            'errors' => array_slice($result->errors, 0, self::PREVIEW_LIMIT),
        ];
    }

    protected function uploadedFile(): ?TemporaryUploadedFile
    {
        $file = collect($this->data['file'] ?? [])->first();

        return $file instanceof TemporaryUploadedFile ? $file : null;
    }
}
