<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Import\BuildsProductExportRows;
use App\Support\WritesSpreadsheet;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportProductsXlsxController extends Controller
{
    public function __invoke(WritesSpreadsheet $writer, BuildsProductExportRows $rows): BinaryFileResponse
    {
        abort_unless(shopper()->auth()->user()?->can('products.create'), Response::HTTP_FORBIDDEN);

        $path = tempnam(sys_get_temp_dir(), 'product-export-');

        if ($path === false) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $xlsxPath = $path.'.xlsx';
        rename($path, $xlsxPath);
        $writer->handle($xlsxPath, $rows->handle());

        return response()
            ->download($xlsxPath, 'products-'.now()->format('Y-m-d').'.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }
}
