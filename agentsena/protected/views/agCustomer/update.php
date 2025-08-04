<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */

$this->breadcrumbs=array(
	'Ag Customers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgCustomer', 'url'=>array('index')),
	array('label'=>'Create AgCustomer', 'url'=>array('create')),
	array('label'=>'View AgCustomer', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage AgCustomer', 'url'=>array('admin')),
);
?>

<h1>Update AgCustomer <?php echo $model->id; ?></h1>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>