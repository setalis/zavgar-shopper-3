<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Enums\ProductImportRowOutcome;
use App\Import\ProductImportRow;
use App\Import\ProductImportTemplate;
use App\Import\RoutesProductImportRow;
use App\Import\StartProductImport;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Components\SlideOverWizard;
use Shopper\Components\Wizard\StepColumn;
use Shopper\Core\Enum\ImportStatus;
use Shopper\Core\Import\Contracts\SupportsColumnMapping;
use Shopper\Core\Import\ImportManager;
use Shopper\Core\Models\ProductImport;
use Shopper\Traits\HandlesAuthorizationExceptions;

/**
 * @property-read Schema $form
 */
final class ImportXlsx extends SlideOverComponent implements HasActions, HasSchemas
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;

    public const PREVIEW_LIMIT = 50;

    public const MAPPABLE_FIELDS = ProductImportTemplate::COLUMNS;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    /** @var array<int, string> */
    public array $fileHeaders = [];

    /** @var array<string, mixed> */
    public array $preview = [];

    public static function panelMaxWidth(): string
    {
        return '4xl';
    }

    public function mount(): void
    {
        $this->authorize('products.create');

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
                                ->label(__('backend.product_imports.xlsx_file'))
                                ->helperText(__('backend.product_imports.xlsx_file_helper'))
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
                                        ->url(route('shopper.products.import-xlsx-template'), shouldOpenInNewTab: true),
                                ),
                        ])
                        ->afterValidation(function (): void {
                            $this->loadFileHeaders();
                        }),
                    StepColumn::make(__('shopper::pages/products.import.steps.mapping'))
                        ->icon(Untitledui::Dataflow04)
                        ->description(__('shopper::pages/products.import.mapping_description'))
                        ->schema([
                            Grid::make()
                                ->schema($this->mappingFields())
                                ->columns(2),
                        ])
                        ->afterValidation(function (): void {
                            $this->buildPreview();
                        }),
                    StepColumn::make(__('shopper::pages/products.import.steps.review'))
                        ->icon(Untitledui::CheckVerified02)
                        ->schema([
                            View::make('livewire.shopper.slide-overs.import-xlsx-preview'),
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

    public function store(): void
    {
        $this->validate();

        $file = $this->uploadedFile();

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        $path = $file->storeAs(
            path: 'shopper/imports',
            name: str()->ulid().'-'.$file->getClientOriginalName(),
            options: 'local'
        );

        $import = ProductImport::query()->create([
            'source' => 'xlsx',
            'disk' => 'local',
            'file_path' => $path,
            'mapping' => array_filter($this->data['mapping'] ?? []),
            'status' => ImportStatus::Pending,
            'user_id' => auth()->id(),
        ]);

        resolve(StartProductImport::class)->execute($import);

        $this->dispatch('products.import.started');

        Notification::make()
            ->title(__('shopper::pages/products.import.started.title'))
            ->body(__('shopper::pages/products.import.started.body'))
            ->success()
            ->send();

        $this->closePanel();
    }

    public function render(): ViewContract
    {
        return view('livewire.shopper.slide-overs.import-xlsx');
    }

    protected function loadFileHeaders(): void
    {
        $file = $this->uploadedFile();

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        $source = resolve(ImportManager::class)->source('xlsx');

        if (! $source instanceof SupportsColumnMapping) {
            return;
        }

        $this->fileHeaders = $source->headers((string) $file->getRealPath());

        foreach (self::MAPPABLE_FIELDS as $field) {
            if (blank($this->data['mapping'][$field] ?? null) && in_array($field, $this->fileHeaders, true)) {
                $this->data['mapping'][$field] = $field;
            }
        }
    }

    protected function buildPreview(): void
    {
        $file = $this->uploadedFile();

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        $source = resolve(ImportManager::class)->source('xlsx');

        if (! $source instanceof SupportsColumnMapping) {
            return;
        }

        $source = $source->withMapping(array_filter($this->data['mapping'] ?? []));

        $products = [];
        $totalProducts = 0;
        $totalVariants = 0;
        $totalStock = 0;
        $totalAttributes = 0;
        $unnamed = 0;
        $skus = [];

        $source->read((string) $file->getRealPath())->each(function (ProductImportRow $importRow) use (&$products, &$totalProducts, &$totalVariants, &$totalStock, &$totalAttributes, &$unnamed, &$skus): void {
            $row = $importRow->product;
            $variantsCount = $row->isStandard() ? 0 : count($row->variants);

            $totalProducts++;
            $totalVariants += $variantsCount;
            $totalStock += array_sum(array_map(fn ($variant): int => $variant->quantity, $row->variants));
            $totalAttributes += count($importRow->attributes);

            if ($row->name === '') {
                $unnamed++;
            }

            if ($importRow->sku !== null) {
                $skus[] = $importRow->sku;
            }

            if (count($products) < self::PREVIEW_LIMIT) {
                $products[] = [
                    'sku' => $importRow->sku,
                    'name' => $row->name,
                    'brand' => $row->brand,
                    'price' => $row->variants[0]->price ?? null,
                    'variants_count' => $variantsCount,
                    'attributes_count' => count($importRow->attributes),
                ];
            }
        });

        $outcomes = resolve(RoutesProductImportRow::class)->outcomesFor($skus);
        $outcomeCounts = array_count_values(array_map(
            fn (string $sku): string => $outcomes[$sku]->value,
            $skus,
        ));

        $this->preview = [
            'products' => array_map(fn (array $product): array => [
                ...$product,
                'outcome' => $product['sku'] === null ? null : $outcomes[$product['sku']]->value,
            ], $products),
            'total_products' => $totalProducts,
            'total_variants' => $totalVariants,
            'total_stock' => $totalStock,
            'total_attributes' => $totalAttributes,
            'unnamed' => $unnamed,
            'outcomes' => [
                ProductImportRowOutcome::Updated->value => $outcomeCounts[ProductImportRowOutcome::Updated->value] ?? 0,
                ProductImportRowOutcome::Queued->value => $outcomeCounts[ProductImportRowOutcome::Queued->value] ?? 0,
                ProductImportRowOutcome::Skipped->value => $outcomeCounts[ProductImportRowOutcome::Skipped->value] ?? 0,
            ],
            'missing_sku' => $totalProducts - count($skus),
        ];
    }

    protected function uploadedFile(): ?TemporaryUploadedFile
    {
        $file = collect($this->data['file'] ?? [])->first();

        return $file instanceof TemporaryUploadedFile ? $file : null;
    }

    /**
     * @return array<int, Select>
     */
    protected function mappingFields(): array
    {
        return array_map(
            fn (string $field): Select => Select::make("mapping.{$field}")
                ->label(__("backend.product_imports.fields.{$field}"))
                ->options(fn (): array => array_combine($this->fileHeaders, $this->fileHeaders))
                ->native(false)
                ->placeholder(__('shopper::pages/products.import.not_mapped'))
                ->required($field === 'name'),
            self::MAPPABLE_FIELDS
        );
    }
}
