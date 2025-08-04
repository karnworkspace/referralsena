<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */

$this->breadcrumbs=array(
	'Ag Requests'=>array('admin'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List AgRequest', 'url'=>array('index')),
	array('label'=>'Create AgRequest', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ag-request-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>รายการยื่นคำร้อง</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-request-grid',
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
		array
        (
               	'name'=>'cus_id',
				'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetCusName($data->cus_id);
				},
		),
		array
        (
               	'name'=>'project_ref',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetProjectName($data->project_ref);
				},
		),
		'comment',
		array
        (
        'header'=>'อนุมัติ',
				'type'=>'raw',
        'value'=>function($data){
			
					$cus_id = $data->cus_id;
					$model_customer = AgCustomer::model()->findByPk($cus_id);

					if($model_customer->sena_approve == 0){
					 			return '<select name="'.$cus_id.'" id="'.$cus_id.'" class="sena-prove"><option value="0" '.($model_customer->sena_approve == 0 ? 'selected="selected"' : "").'>รออนุมัติ</option><option value="1" '.($model_customer->sena_approve == 1 ? 'selected="selected"' : "").'>ผ่าน</option><option value="2" '.($model_customer->sena_approve == 2 ? 'selected="selected"' : "").'>ไม่ผ่าน</option></select>';

					}else{
						if($model_customer->sena_approve == 1){
						
							return "<b style=\"color:green;\">ผ่าน</b>";
						}else{
							return "<b style=\"color:red;\">ไม่ผ่าน</b>";
						}
					}
					
				}
		),
		array
        (
        'header'=>'ผู้ทำรายการ',
				'type'=>'raw',
        'value'=>function($data){
					$cus_id = $data->cus_id;
					$model_customer = AgCustomer::model()->findByPk($cus_id);
					
					if($model_customer->update_by != 0){
						$txt_sale_name = JobFunction::GetSaleEmail($model_customer->update_by)." : ".DateThai::date_thai_convert_time($model_customer->update_date,true);
					 		return $txt_sale_name;

					}else{
							return "";
					}
					
				}
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>

<script type="text/javascript">
(function($){
$(document).on('change','.sena-prove',function(){
	var r = confirm("คุณต้องการเปลี่ยนสถานะใช่หรือไม่");
	if (r == true) {
		var Id = $(this).attr("id");
			$.ajax({
						type: "POST",
						data: {prove_id:Id,prove_st:this.value},
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
