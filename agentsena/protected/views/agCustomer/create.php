<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */

$this->breadcrumbs=array(
	'Ag Customers'=>array('index'),
	'Create',
);

// $this->menu=array(
// 	array('label'=>'รายชื่อลูกค้า', 'url'=>array('index')),
// 	//array('label'=>'Manage AgCustomer', 'url'=>array('admin')),
// );
?>
<div class="container-fluid">
<h1>เพิ่มข้อมูลลูกค้า</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
