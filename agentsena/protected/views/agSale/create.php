<?php
/* @var $this AgSaleController */
/* @var $model AgSale */

$this->breadcrumbs=array(
	'Ag Sales'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AgSale', 'url'=>array('index')),
	array('label'=>'Manage AgSale', 'url'=>array('admin')),
);
?>

<h1>Create AgSale</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>