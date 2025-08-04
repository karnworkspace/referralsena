<?php
/* @var $this AgVisitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Visits',
);

$this->menu=array(
	array('label'=>'Create AgVisit', 'url'=>array('create')),
	array('label'=>'Manage AgVisit', 'url'=>array('admin')),
);
?>

<h1>Ag Visits</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
