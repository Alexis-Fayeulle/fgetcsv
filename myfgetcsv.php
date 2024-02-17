<?php declare(strict_types=1);

/**
 * @param resource $stream The opened file in read
 * @param int|null $length Length max of a line in file
 * @return array<int, scalar>|null
 */
function myfgetcsv($stream, ?int $length = null, string $separator = ',', string $enclosure = '"', string $escape = '\\', string $eol = PHP_EOL): ?array
{
    if (!is_resource($stream)) {
        return null;
    }

    // Reduce to one char
    $separator = $separator[0];
    $enclosure = $enclosure[0];
    $escape = $escape[0];
    $eol = $eol[0];
    $line = [];

    do {
        $mode_enclosure = false;
        $enclosure_count = 0;
        $i = 0;
        $field = '';

        // Read the field
        do {
            if ($enclosure_count >= 2) {
                $enclosure_count = 0;
            }

            $c = fgetc($stream);
            $isEnclosure = $c === $enclosure;
            $isEnd = $c === $separator || $c === $eol || $c === false;

            if ($i === 0) {
                if ($isEnclosure) {
                    $mode_enclosure = true;
                }

                if ($isEnd) {
                    break;
                }
            }

            if ($isEnd && $enclosure_count === 1) {
                $mode_enclosure = false;
            }

            if ($isEnclosure) {
                $enclosure_count++;
            } else {
                $enclosure_count = 0;
            }

            if ($mode_enclosure && $c !== $enclosure) {
                $field .= $c;
            }

            if ($mode_enclosure && $c === $enclosure && $enclosure_count === 2) {
                $field .= $c;
            }

            if (!$mode_enclosure && !$isEnd) {
                $field .= $c;
            }

            $i++;
        } while($mode_enclosure === true || !$isEnd);

        $line[] = $field;
    } while ($c !== $eol && $c !== false);

    if (count($line) === 1 && $line[0] === '') {
        return null;
    }

    return $line;
}
