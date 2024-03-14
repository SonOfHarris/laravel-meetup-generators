<?php

function xrange($start, $end, $step) {
    $pos = $start;
    while ($pos <= $end) {
        yield $pos;
        $pos += $step;
    }
}

foreach (xrange(1, 100, 3) as $v) {
    echo "{$v}, ";
}

// 1, 4, 7, 10, ..., 100,
