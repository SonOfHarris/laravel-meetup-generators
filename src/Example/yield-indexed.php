<?php

function xrange($start, $end, $step) {
    $pos = $start;
    while ($pos <= $end) {
        yield $pos;
        $pos += $step;
    }
}

foreach (xrange(1, 100, 3) as $k => $v) {
    echo var_export($k, true) . " => " . var_export($v, true) . PHP_EOL;
}

// 0 => 1
// 1 => 4
// 2 => 7
// ...
// 32 => 97
// 33 => 100
