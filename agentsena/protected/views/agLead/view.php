<?php
/* @var $this AgLeadController */
/* @var $model AgLead */

$this->breadcrumbs=array(
	'Ag Leads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AgLead', 'url'=>array('index')),
	array('label'=>'Create AgLead', 'url'=>array('create')),
	array('label'=>'Update AgLead', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AgLead', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AgLead', 'url'=>array('admin')),
);
?>

<h1>View AgLead #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lead_id',
		'fname',
		'lname',
		'email',
		'phone',
		'visitdate',
	),
)); ?>
