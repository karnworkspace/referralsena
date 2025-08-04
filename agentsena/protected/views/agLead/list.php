<?php
/* @var $this AgLeadController */
/* @var $model AgLead */

$this->breadcrumbs=array(
	'Ag Leads'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AgLead', 'url'=>array('index')),
	array('label'=>'Create AgLead', 'url'=>array('create')),
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
");
?>

<h4>รายชื่อ Lead (ถังเก่า)</h4>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-lead-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lead_id',
		'fname',
		'lname',
		'email',
		'phone',
		
		'visitdate',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
