<?php

$chunk = (int) $argv[1];
$time_limit = (float) $argv[2];

echo 'chunk: '.$chunk.PHP_EOL;
echo 'time_limit: '.($time_limit == 0 ? 'Infinite' : $time_limit).PHP_EOL;

$f = fopen(__DIR__.'/very_big_csv.csv', 'rb');

$diff = 0;
$count = 0;
$start = microtime(true);

do {
    for ($i = 0; $i < $chunk; $i++) {
        $d = fgetcsv($f);
        $count++;
    }

    $diff = microtime(true) - $start;

    if ($time_limit != 0 && $diff > $time_limit) {
        break;
    }
} while ($d !== false);

$stop = microtime(true);
fclose($f);
$diff = $stop - $start;

echo 'time: '.$diff.PHP_EOL;
echo 'count: '.$count.PHP_EOL;
echo number_format($count / $diff, 0, '', '').' i/s'.PHP_EOL;
