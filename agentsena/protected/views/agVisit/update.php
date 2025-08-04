<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */

$this->breadcrumbs=array(
	'Ag Visits'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgVisit', 'url'=>array('index')),
	array('label'=>'Create AgVisit', 'url'=>array('create')),
	array('label'=>'View AgVisit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AgVisit', 'url'=>array('admin')),
);
?>

<h1>Update AgVisit <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>