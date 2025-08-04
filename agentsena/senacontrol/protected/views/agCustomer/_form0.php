<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ag-customer-form',
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
		<?php echo $form->textField($model,'agent_id',array('value'=>Yii::app()->user->code_ref,'size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'agent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fname'); ?>
		<?php echo $form->textField($model,'fname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lname'); ?>
		<?php echo $form->textField($model,'lname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'lname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project'); ?>
        <?php echo $form->dropDownList($model,'project', CHtml::listData(Project::model()->findAll(), 'id', 'project_name'), array('empty'=>'กรุณาเลือกโครงการ')) ?> 
        
		<?php echo $form->error($model,'project'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget'); ?>
		<?php echo $form->textField($model,'budget',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idcard'); ?>
		<?php echo $form->textField($model,'idcard',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'idcard'); ?>
	</div>

<?php /*?>	<div class="row">
		<?php echo $form->labelEx($model,'is_duplicate'); ?>
		<?php echo $form->textField($model,'is_duplicate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'is_duplicate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('row'=>5,'col'=>5)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div><?php */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->