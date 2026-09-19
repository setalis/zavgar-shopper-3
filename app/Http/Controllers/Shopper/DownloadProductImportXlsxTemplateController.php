<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Support\WritesSpreadsheet;
use Illuminate\Http\Response;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class DownloadProductImportXlsxTemplateController extends Controller
{
    public function __invoke(WritesSpreadsheet $writer): BinaryFileResponse
    {
        abort_unless(shopper()->auth()->user()?->can('products.create'), Response::HTTP_FORBIDDEN);

        $reader = Reader::from(base_path('vendor/shopper/framework/public/templates/product-import.csv'));
        $rows = [];

        foreach ($reader->getRecords() as $record) {
            $rows[] = array_values($record);
        }

        $path = tempnam(sys_get_temp_dir(), 'product-import-');

        if ($path === false) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $xlsxPath = $path.'.xlsx';
        rename($path, $xlsxPath);
        $writer->handle($xlsxPath, $rows);

        return response()
            ->download($xlsxPath, 'product-import.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }
}
