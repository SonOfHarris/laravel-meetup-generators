<?php

function xrange($start, $end, $step) {
    $range = [];
    $pos = $start;
    while ($pos <= $end) {
        $range[] = $pos;
        $pos += $step;
    }
    return $range;
}

foreach (xrange(1, 100, 3) as $v) {
    echo "{$v}, ";
}

// 1, 4, 7, 10, ..., 100,
