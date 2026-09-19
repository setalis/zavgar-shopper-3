<?php

declare(strict_types=1);

namespace App\Support;

use DateInterval;
use DateTimeInterface;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

final class WritesSpreadsheet
{
    /**
     * @param  list<list<null|bool|DateInterval|DateTimeInterface|float|int|string>>  $rows
     */
    public function handle(string $path, array $rows): void
    {
        $writer = new Writer;
        $writer->openToFile($path);

        try {
            foreach ($rows as $row) {
                $writer->addRow(Row::fromValues($row));
            }
        } finally {
            $writer->close();
        }
    }
}
