<?php
/* @var $this AgLeadController */
/* @var $model AgLead */

$this->breadcrumbs=array(
	'Ag Leads'=>array('index'),
	'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ag-lead-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('#btn-reset').click(function(){
	location.reload();
	return false;
});
");
?>

<h1>รายชื่อ Lead ในระบบตั้งแต่วันที่ 1 ธ.ค. เป็นต้นมา</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-lead-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'lead_id',
		'fname',
		'lname',
		'email',
		'phone',
		// 'visitdate',
		/*'VisitDate',*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
