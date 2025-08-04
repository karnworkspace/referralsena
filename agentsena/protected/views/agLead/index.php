<?php
/* @var $this AgLeadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Leads',
);

$this->menu=array(
	array('label'=>'Create AgLead', 'url'=>array('create')),
	array('label'=>'Manage AgLead', 'url'=>array('admin')),
);
?>

<h1>Ag Leads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
