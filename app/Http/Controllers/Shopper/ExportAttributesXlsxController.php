<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Import\BuildsAttributeExportRows;
use App\Support\WritesSpreadsheet;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportAttributesXlsxController extends Controller
{
    public function __invoke(WritesSpreadsheet $writer, BuildsAttributeExportRows $rows): BinaryFileResponse
    {
        abort_unless(shopper()->auth()->user()?->can('attributes.browse'), Response::HTTP_FORBIDDEN);

        $path = tempnam(sys_get_temp_dir(), 'attribute-export-');

        if ($path === false) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $xlsxPath = $path.'.xlsx';
        rename($path, $xlsxPath);
        $writer->handle($xlsxPath, $rows->handle());

        return response()
            ->download($xlsxPath, 'attributes-'.now()->format('Y-m-d').'.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }
}
