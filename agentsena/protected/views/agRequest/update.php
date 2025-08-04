<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */

$this->breadcrumbs=array(
	'Ag Requests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgRequest', 'url'=>array('index')),
	array('label'=>'Create AgRequest', 'url'=>array('create')),
	array('label'=>'View AgRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AgRequest', 'url'=>array('admin')),
);
?>

<h1>Update AgRequest <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>