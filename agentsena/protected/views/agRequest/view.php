<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */

$this->breadcrumbs=array(
	'Ag Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('index')),);
?>

<h1>ยื่นคำร้องเรียบร้อย #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array
        (
                'name'=>'cus_id',
                'value'=>function($data){
					$model_customer = AgCustomer::model()->findBYPk($data->cus_id);
					if($model_customer){
						return $model_customer->fname." ".$model_customer->lname;
					}
				},
        ),
		'agent_id',
		'comment',
	),
)); ?>
