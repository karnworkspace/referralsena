<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */

$this->breadcrumbs=array(
	'Ag Requests'=>array('index'),
	'Create',
);

// $this->menu=array(
// 	array('label'=>'List AgRequest', 'url'=>array('index')),
// 	array('label'=>'Manage AgRequest', 'url'=>array('admin')),
// );
?>
<div class="container-fluid">
<h1>ยื่นคำร้องใหม่</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
