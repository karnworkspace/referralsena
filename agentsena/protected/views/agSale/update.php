<?php
/* @var $this AgSaleController */
/* @var $model AgSale */

$this->breadcrumbs=array(
	'Ag Sales'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgSale', 'url'=>array('index')),
	array('label'=>'Create AgSale', 'url'=>array('create')),
	array('label'=>'View AgSale', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AgSale', 'url'=>array('admin')),
);
?>

<h1>Update AgSale <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>