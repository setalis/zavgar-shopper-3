<?php

declare(strict_types=1);

namespace App\Enums;

enum AttributeImportRowOutcome: string
{
    case Updated = 'updated';
    case Queued = 'queued';
}
