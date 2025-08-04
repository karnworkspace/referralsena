<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */

$this->breadcrumbs=array(
	'Ag Visits'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List AgVisit', 'url'=>array('index')),
	array('label'=>'Create AgVisit', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ag-visit-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>รายการนัดหมายเยี่ยมชมโครงการ</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-visit-grid',
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
               	'name'=>'project',
				'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetProjectName($data->project);
				},
		),
		array
        (
               	'name'=>'visit_date',
				'type'=>'raw',
                'value'=>function($data){
					return DateThai::date_thai_convert($data->visit_date,false);
				},
		),
		/*
		array
        (
               	'header'=>'Approve',
				'type'=>'raw',
               	'value'=>function($data){
					$prove_id = $data->id;
					
					$prove_id_st = $data->status;
					
					if($prove_id_st == 1){
					 	$ele_check = 'checked="checked"';
					}else{
						$ele_check = '';
					}
					return '<input type="checkbox" name="'.$prove_id.'" id="'.$prove_id.'" class="agent-prove" '.$ele_check.'>';
				}
		),
		
		'create_by',
		'status',
		'staff_id',
		'status_date',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
<script type="text/javascript">
(function($){


$(".agent-prove").click(function () {

	if ($(this).is(":checked")) {
	var Id = $(this).attr("id");
		$.ajax({
					type: "POST",
					data: {prove_id:Id,prove_st:1},
					url: "<?=CController::createUrl('agVisit/AjaxAprove')?>",//actionname
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
					url: "<?=CController::createUrl('agVisit/AjaxAprove')?>",//actionname
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