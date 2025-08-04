<?php
/* @var $this AgSaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Sales',
);

$this->menu=array(
	array('label'=>'Create AgSale', 'url'=>array('create')),
	array('label'=>'Manage AgSale', 'url'=>array('admin')),
);
?>

<h1>Ag Sales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
