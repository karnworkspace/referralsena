<?php
/* @var $this AgLeadController */
/* @var $model AgLead */

$this->breadcrumbs=array(
	'Ag Leads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('list')),
);
?>

<h1>รายการที่ #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lead_id',
		'fname',
		'lname',
		'email',
		'phone',
		'visitdate',
	),
)); ?>
