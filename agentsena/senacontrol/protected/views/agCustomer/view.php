<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */

$this->breadcrumbs=array(
	'Ag Customers'=>array('view'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('admin')),
// 	array('label'=>'Create AgCustomer', 'url'=>array('create')),
// 	//array('label'=>'Update AgCustomer', 'url'=>array('update', 'id'=>$model->id)),
// 	//array('label'=>'Delete AgCustomer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	//array('label'=>'Manage AgCustomer', 'url'=>array('admin')),
);
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">ข้อมูลลูกค้า</a></li>
    <li class="breadcrumb-item active" aria-current="page">ข้อมูลลูกค้า <?php echo $model->fname; ?> <?php echo $model->lname; ?></li>
  </ol>
</nav>
<div class="container-fluid">
<h1>รายละเอียดลูกค้า <?php echo $model->fname; ?> <?php echo $model->lname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'agent_id',
		array
        (
               	'name'=>'ชื่อ-สกุล นายหน้า',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetAgentName($data->create_by);
				},
		),
		'fname',
		'lname',
		'idcard',
		array
        (
                'name'=>'project',
                'value'=>function($data){
					$project_id = Project::model()->findBYPk($data->project);
					if($project_id){
						return $project_id->project_name;
					}
				},
        ),

		// array
    //     (
    //             'name'=>'project',
    //             'value'=>function($data){
		// 			$project_id = Project::model()->findByPk($id);
		// 			if($project_id){
		// 				return $project_id->project_name;
		// 			}
		// 		},
		// 	),
			array
	        (
	                'name'=>'budget',
	                'value'=>function($data){
						$model_bud = Budget::model()->findByPk($data->budget);
						if($model_bud){
							return $model_bud->bud_name;
						}
					}
				),
		// 'project' = > JobFunction::GetProjectName($data->project),
		// 'budget',
		'phone',
		// 'is_duplicate',
		// 'duplicate_lead_id',
		array
        (
               	'name'=>'is_duplicate',
								'type'=>'raw',
                'value'=>function($data){
						if($data->is_duplicate == "y"){
							return "<a href=".Yii::app()->createUrl('agCustomer/duplicate',array("id"=>$data->id))." target='_blank'><b style=\"color:red;\">รายชื่อคล้ายกัน</b></a>";
						}else{
							return "<b style=\"color:green;\">ผ่าน</b>";
						}
				},
		),
			array
	        (
	            'name'=>'create_date',
                'value'=>function($data){
						if($data->create_date){
							return DateThai::date_thai_convert_time($data->create_date,true);
						}
				}
			),

		// 'user_ip',
		array
        (
        'name'=>'เจ้าหน้าที่อนุมัติ',
				'type'=>'raw',
        'value'=>function($data){
					if($data->sena_approve == 0){
					 			/*return '<select name="'.$data->id.'" id="'.$data->id.'" class="sena-prove"><option value="0" '.($data->sena_approve == 0 ? 'selected="selected"' : "").'>รออนุมัติ</option><option value="1" '.($data->sena_approve == 1 ? 'selected="selected"' : "").'>ผ่าน</option><option value="2" '.($data->sena_approve == 2 ? 'selected="selected"' : "").'>ไม่ผ่าน</option></select>';*/

					  return '<input type="radio" id="prove" name="prove" value="1" class="sena-prove" data-id="'.$data->id.'">
					  <label for="prove" style="color:green;">ผ่าน</label><br>
					  <input type="radio" id="not-prove" name="prove" value="2" class="sena-prove" data-id="'.$data->id.'">
					  <label for="not-prove" style="color:red;">ไม่ผ่าน</label><br>';


					}else{
						if($data->sena_approve == 1){

							return "<b style=\"color:green;\">ผ่าน</b>";
						}else{
							return "<b style=\"color:red;\">ไม่ผ่าน</b>";
						}
					}

				}
		),
		array
        (
        'name'=>'ผู้ทำรายการ',
				'type'=>'raw',
        'value'=>function($data){
					if($data->update_by != 0){
						$txt_sale_name = JobFunction::GetSaleEmail($data->update_by)." : ".DateThai::date_thai_convert_time($data->update_date,true);
					 		return $txt_sale_name;

					}else{
							return "";
					}

				}
		),

		array
        (
        'name'=>'',
				'type'=>'raw',
        'value'=>function($data){
					if($data->sena_approve == 0){
					 		return '<div><font color="red">กรุณาตรวจสอบข้อมูลอย่างละเอียด ก่อนกดปุ่ม "ยืนยัน" เนื่องจากจะมีข้อความส่งให้นายหน้าทันที ว่าลูกค้าได้ผ่านการตรวจสอบแล้ว</font></div><input type="button" name="btn-prove" id="btn-prove" value="ยืนยัน" />';
					}else{
							return "";
					}

				}
		),

	),
)); ?>
</div>
<script type="text/javascript">
(function($){
$(document).on('click','#btn-prove',function(){
	var prove_val =  $("input[name='prove']:checked").val();
	var Id = $("input[name='prove']:checked").attr("data-id");

	if (typeof prove_val !== 'undefined') {
		var r = confirm("คุณต้องการเปลี่ยนสถานะใช่หรือไม่");
		if (r == true) {
				$.ajax({
							type: "POST",
							data: {prove_id:Id,prove_st:prove_val},
							url: "<?=CController::createUrl('agCustomer/AjaxAprove')?>",//actionname
							dataType: "html",
							success: function(result){

								if(result == "1"){
									alert("success");
									location.reload();
								}else if(result == "0"){
									alert("unsuccess");
									location.reload();
								}else{
									alert("Select Status First");
									location.reload();
								}

						}});
		}else{
			$("input[name='prove']").attr('checked', false);
		}

	}else{
		alert("Select Status First");
	}
});


})(jQuery);

</script>
