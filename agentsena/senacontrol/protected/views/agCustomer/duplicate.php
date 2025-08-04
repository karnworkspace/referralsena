<?php
//print_r($model);

$duplicate_id = $model->duplicate_lead_id;

$arr_duplicate_id = json_decode($duplicate_id,true);
$count = 1;
foreach ($arr_duplicate_id as $val_duplicate_id) {
	if($val_duplicate_id['tb'] == "lead"){
		echo $count.". ".JobFunction::GetDuplicateName($val_duplicate_id['lead_id'],'lead')." : <span style=\"color:red;\">ลูกค้าท่านนี้เคยลงทะเบียนมาแล้วเมื่อวันที่ ".DateThai::birth_date_thai_convert(JobFunction::GetVisitDate($val_duplicate_id['lead_id']),true)."</span><br />";
		
	}
	
	if($val_duplicate_id['tb'] == "cus"){
		echo $count.". ".JobFunction::GetDuplicateName($val_duplicate_id['cus_id'],'cus')." : <span style=\"color:red;\">ลูกค้าท่านนี้เคยลงทะเบียนมาแล้วในโครงการ".JobFunction::GetProjectName(JobFunction::GetProjectID($val_duplicate_id['cus_id']))."</span><br />";
	}
	$count++;
}
//}

?>
