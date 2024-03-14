<?php

function xrange($start, $end, $step) {
    $count = 0;
    $pos = $start;
    while ($pos <= $end) {
        // Keys from A-Z
        yield chr(65 + $count++) => $pos;
        $pos += $step;
        if ($count >= 26) {
            $count = 0;
        }
    }
}

foreach (xrange(1, 100, 3) as $k => $v) {
    echo var_export($k, true) . " => " . var_export($v, true) . PHP_EOL;
}

// 'A' => 1
// 'B' => 4
// 'C' => 7
// ...
// 'A' => 79
// 'B' => 82
// 'C' => 85
// ...
// 'H' => 100
