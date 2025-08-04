<?php
//print_r($model);

$duplicate_id = $model->duplicate_lead_id;

$arr_duplicate_id = json_decode($duplicate_id,true);
$count = 1;
foreach ($arr_duplicate_id as $val_duplicate_id) {
	if($val_duplicate_id['tb'] == "lead"){
		echo $count.". ".JobFunction::GetDuplicateName($val_duplicate_id['lead_id'],'lead')."<br />";
		
	}
	
	if($val_duplicate_id['tb'] == "cus"){
		echo $count.". ".JobFunction::GetDuplicateName($val_duplicate_id['cus_id'],'cus')."<br />";
	}
	$count++;
}
//}

?>
