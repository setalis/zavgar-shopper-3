<?php

declare(strict_types=1);

namespace App\Import;

use App\Enums\AttributeImportRowOutcome;

final class ImportsAttributeFile
{
    public function __construct(
        private ParsesAttributeImportFile $parser,
        private RoutesAttributeImportRow $router,
    ) {}

    public function inspect(string $path): AttributeImportResult
    {
        $parsed = $this->parser->parse($path);
        $rows = [];
        $errors = $parsed['errors'];
        $updated = 0;
        $queued = 0;

        foreach ($parsed['rows'] as $row) {
            try {
                $outcome = $this->router->outcome($row);
            } catch (AttributeImportException $exception) {
                $errors[] = ['line' => $row->line, 'message' => $exception->getMessage()];
                $rows[] = $this->previewRow($row, null, $exception->getMessage());

                continue;
            }

            if ($outcome === AttributeImportRowOutcome::Updated) {
                $updated++;
            } else {
                $queued++;
            }

            $rows[] = $this->previewRow($row, $outcome, null);
        }

        return new AttributeImportResult($updated, $queued, $errors, $rows);
    }

    public function handle(string $path): AttributeImportResult
    {
        $parsed = $this->parser->parse($path);
        $rows = [];
        $errors = $parsed['errors'];
        $updated = 0;
        $queued = 0;

        foreach ($parsed['rows'] as $row) {
            try {
                $outcome = $this->router->route($row);
            } catch (AttributeImportException $exception) {
                $errors[] = ['line' => $row->line, 'message' => $exception->getMessage()];
                $rows[] = $this->previewRow($row, null, $exception->getMessage());

                continue;
            }

            if ($outcome === AttributeImportRowOutcome::Updated) {
                $updated++;
            } else {
                $queued++;
            }

            $rows[] = $this->previewRow($row, $outcome, null);
        }

        return new AttributeImportResult($updated, $queued, $errors, $rows);
    }

    /**
     * @return array{line: int, name: string, slug: string, outcome: ?string, error: ?string}
     */
    private function previewRow(AttributeImportRow $row, ?AttributeImportRowOutcome $outcome, ?string $error): array
    {
        return [
            'line' => $row->line,
            'name' => $row->name,
            'slug' => $row->slug,
            'outcome' => $outcome?->value,
            'error' => $error,
        ];
    }
}
