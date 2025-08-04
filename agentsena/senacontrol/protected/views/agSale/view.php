<?php
/* @var $this AgSaleController */
/* @var $model AgSale */

$this->breadcrumbs=array(
	'Ag Sales'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AgSale', 'url'=>array('index')),
	array('label'=>'Create AgSale', 'url'=>array('create')),
	array('label'=>'Update AgSale', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AgSale', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AgSale', 'url'=>array('admin')),
);
?>

<h1>View AgSale #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'staffid',
		'name',
		'position',
		'project',
		'email',
		'phone',
		'status',
	),
)); ?>
