<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Import\AttributeImportTemplate;
use App\Support\WritesSpreadsheet;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class DownloadAttributeImportXlsxTemplateController extends Controller
{
    public function __invoke(WritesSpreadsheet $writer, AttributeImportTemplate $template): BinaryFileResponse
    {
        abort_unless(shopper()->auth()->user()?->can('attributes.create'), Response::HTTP_FORBIDDEN);

        $path = tempnam(sys_get_temp_dir(), 'attribute-import-');

        if ($path === false) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $xlsxPath = $path.'.xlsx';
        rename($path, $xlsxPath);
        $writer->handle($xlsxPath, $template->rows());

        return response()
            ->download($xlsxPath, 'attribute-import.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }
}
