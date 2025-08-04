<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */
/* @var $form CActiveForm */
?>

<div class="container-fluid alert alert-success">

<h3>ค้นหารายชื่อลูกค้า</h3>


<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fname'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'fname',array('size'=>30,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lname'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'lname',array('size'=>30,'maxlength'=>50)); ?>
	</div>

	<!-- <div class="row">
		<?php echo $form->label($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'phone',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idcard'); ?>
	</div>
	<div class="row">
		<?php echo $form->textField($model,'idcard',array('size'=>50,'maxlength'=>50)); ?>
	</div> -->
<br />
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::resetButton('Reset',array('id'=>'btn-reset')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
