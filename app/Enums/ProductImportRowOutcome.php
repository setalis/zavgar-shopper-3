<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductImportRowOutcome: string
{
    case Updated = 'updated';
    case Queued = 'queued';
    case Skipped = 'skipped';
}
