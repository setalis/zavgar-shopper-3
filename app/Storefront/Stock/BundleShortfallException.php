<?php

declare(strict_types=1);

namespace App\Storefront\Stock;

use RuntimeException;

/**
 * Unwinds the bundle's savepoint so components reserved before the short one are released.
 */
final class BundleShortfallException extends RuntimeException
{
    public function __construct(
        public readonly int $fulfillableBundles,
    ) {
        parent::__construct('A bundle component is short of stock.');
    }
}
