<?php
/* @var $this AgLeadController */
/* @var $model AgLead */

$this->breadcrumbs=array(
	'Ag Leads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AgLead', 'url'=>array('index')),
	array('label'=>'Manage AgLead', 'url'=>array('admin')),
);
?>

<h1>Create AgLead</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>