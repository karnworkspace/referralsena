<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */

$this->breadcrumbs=array(
	'Ag Requests'=>array('index'),
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
               	'name'=>'cus_id',
				'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetCusName($data->cus_id);
				},
		),
		array
        (
               	'header'=>'ชื่อ-สกุล นายหน้า',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetAgentName($data->create_by);
				},
		),
		'comment',
		array
        (
               	'header'=>'Approve',
				'type'=>'raw',
               	'value'=>function($data){
					$cus_id = $data->cus_id;
					
					$model_customer = AgCustomer::model()->findByPk($cus_id);
					
					if($model_customer->sena_approve == 1){
					 	$ele_check = 'checked="checked"';
					}else{
						$ele_check = '';
					}
					return '<input type="checkbox" name="'.$cus_id.'" id="'.$cus_id.'" class="sena-prove" '.$ele_check.'>';
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
							location.reload();
							
						}else if(result == "0"){
							alert("unsuccess");
						}else{
							alert("unsuccess");
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
							location.reload();
							
						}else if(result == "0"){
							alert("unsuccess");
						}else{
							alert("unsuccess");
						}

				}});		
	
		
	}
});

})(jQuery); 
</script>