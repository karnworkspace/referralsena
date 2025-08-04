<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */
//echo Yii::app()->user->project."<br/>";
//echo Yii::app()->user->user_type;


$this->breadcrumbs=array(
	'Ag Customers'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List AgCustomer', 'url'=>array('index')),
//	array('label'=>'Create AgCustomer', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ag-customer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    <div class="row">

<h1>รายการลูกค้าทั้งหมด</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//));



?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-customer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array
        (
               	'header'=>'ชื่อ-สกุล นายหน้า',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetAgentName($data->create_by);
				},
		),
		// array
    //     (
    //            	'name'=>'agent_id',
		// 						'type'=>'raw',
    //             'value'=>function($data){
		// 				return JobFunction::GetAgentName($data->agent_id);
		// 				// return CHtml::encode($value_model->agent_id);
		// 		},
		// ),
		'fname',
		'lname',
		array
        (
               	'name'=>'project',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetProjectName($data->project);
				},
		),
		array
        (
               	'name'=>'budget',
								'type'=>'raw',
                'value'=>function($data){
						$model_bud = Budget::model()->findByPk($data->budget);
						if($model_bud){
							return $model_bud->bud_name;
						}else{
							return "-";
						}

				},
		),
		'phone',
		'idcard',
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
		'create_date',
		array
        (
        'header'=>'อนุมัติ',
				'type'=>'raw',
        'value'=>function($data){
					if($data->sena_approve == 1){
					 	$ele_check = 'checked="checked"';
					}else{
							$ele_check = '';
							}
// 							if($data->sena_approve == 1){
// 								$ele_check = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
// 		  <button type="button" class="btn btn-success sena-prove" name="'.$data->id.'" id="'.$data->id.'">Y</button>
// 		  <button type="button" class="btn btn-secondary" name="'.$data->id.'" id="'.$data->id.'">N</button>
// 		</div>';
// 							}else if($data->sena_approve == 0){
// 									$ele_check = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
// 		  <button type="button" class="btn btn-secondary sena-prove" name="'.$data->id.'" id="'.$data->id.'">Y</button>
// 		  <button type="button" class="btn btn-danger" name="'.$data->id.'" id="'.$data->id.'">N</button>
// 		</div>';
// 						}else{
// 							$ele_check ='<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
//   <button type="button" class="btn btn-secondary sena-prove" name="'.$data->id.'" id="'.$data->id.'">Y</button>
//   <button type="button" class="btn btn-secondary" name="'.$data->id.'" id="'.$data->id.'">N</button>
// </div>';
// 							}
					// else{
					// 	$ele_check = '<input type="radio" name="'.$data->id.'" id="'.$data->id.'" class="sena-prove" > <input type="radio" name="'.$data->id.'" id="'.$data->id.'" >';
					// }
					// return $ele_check;
					// return '<input type="radio" name="'.$data->id.'" id="'.$data->id.'" class="sena-prove" '.$ele_check.'> <input type="radio" name="'.$data->id.'" id="'.$data->id.'" class="sena-prove" >';
					return '<input type="checkbox" name="'.$data->id.'" id="'.$data->id.'" class="sena-prove" '.$ele_check.'> ';
				}
		),

		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
</div>
</div>
<script type="text/javascript">
(function($){


$(".sena-prove").click(function () {

	if ($(this).is(":checked")) {
	var Id = $(this).attr("id");
		$.ajax({
					type: "POST",
					data: {prove_id:Id,prove_st:1},
					url: "<?=CController::createUrl('agCustomer/AjaxAprove')?>",//actionname
					dataType: "html",
					success: function(result){

						if(result == "1"){
							alert("success");

						}else if(result == "0"){
							alert("unsuccess");
						}else{
							alert("Select Status First");
						}

				}});


	}else{
	var Id = $(this).attr("id");
		$.ajax({
					type: "POST",
					data: {prove_id:Id,prove_st:0},
					url: "<?=CController::createUrl('agCustomer/AjaxAprove')?>",//actionname
					dataType: "html",
					success: function(result){

						if(result == "1"){
							alert("success");

						}else if(result == "0"){
							alert("unsuccess");
						}else{
							alert("Select Status First");
						}

				}});


	}
});

})(jQuery);

</script>
