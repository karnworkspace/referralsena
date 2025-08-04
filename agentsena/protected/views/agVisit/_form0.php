<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ag-visit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'agent_id'); ?>
		<?php echo $form->textField($model,'agent_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'agent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cus_id'); ?>
		<?php echo $form->textField($model,'cus_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cus_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project'); ?>
		<?php echo $form->textField($model,'project',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'project'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visit_date'); ?>
		<?php echo $form->textField($model,'visit_date',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'visit_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_date'); ?>
		<?php echo $form->textField($model,'status_date',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'status_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->