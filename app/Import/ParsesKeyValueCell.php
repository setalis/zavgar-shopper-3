<?php

declare(strict_types=1);

namespace App\Import;

final class ParsesKeyValueCell
{
    /**
     * Parses "Key: value; Key: value | value" into keys with their values.
     *
     * @return array<string, list<string>>
     */
    public function handle(?string $cell): array
    {
        $pairs = [];

        foreach (explode(';', (string) $cell) as $pair) {
            [$key, $value] = array_pad(explode(':', $pair, 2), 2, '');
            $key = mb_trim($key);

            $values = array_values(array_filter(
                array_map(mb_trim(...), explode('|', $value)),
                fn (string $value): bool => $value !== '',
            ));

            if ($key === '' || $values === []) {
                continue;
            }

            $pairs[$key] = array_values(array_unique([...($pairs[$key] ?? []), ...$values]));
        }

        return $pairs;
    }
}
