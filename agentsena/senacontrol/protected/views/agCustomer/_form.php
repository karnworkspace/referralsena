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

	<table class="detail-view col-12" id="yw0"><tbody>
	<tr class="even">
		<th><?php echo $form->labelEx($model,'เลขนายหน้า*'); ?></th>
		<td><?php echo $form->textField($model,'agent_id',array('value'=>Yii::app()->user->code_ref,'size'=>20,'readOnly'=>true,'maxlength'=>20,'class' => 'col-6')); ?><?php echo $form->error($model,'agent_id'); ?></td></tr>
		<tr><th>คำนำหน้า</th>
		<td><select required>
			<option value=""></option>
			<option value="นาย">นาย</option>
			<option value="นาง">นาง</option>
			<option value="นางสาว">นางสาว</option>
			<option value="Mr">Mr</option>
			<option value="Miss">Miss</option>
			<option value="Mrs">Mrs</option>
		</select></td></tr>
	<tr class="odd"><th><?php echo $form->labelEx($model,'ชื่อลูกค้า*'); ?></th>
		<td><?php echo $form->textField($model,'fname',array('size'=>50,'minlength'=>2,'maxlength'=>50,'class' => 'col-3')); ?><?php echo $form->error($model,'fname'); ?></td></tr>

	<tr class="even"><th><?php echo $form->labelEx($model,'สกุลลูกค้า*'); ?></th><td><?php echo $form->textField($model,'lname',array('size'=>50,'minlength'=>2,'maxlength'=>50,'class' => 'col-3')); ?>
	<?php echo $form->error($model,'lname'); ?></td></tr>

	<tr class="col-4"><th><?php echo $form->labelEx($model,'โครงการที่ลูกค้าสนใจ*'); ?></th><td><?php echo $form->dropDownList($model,'project', CHtml::listData(Project::model()->findAll(array('order' => 'project_name ASC')), 'id', 'project_name', 'project_type'), array('empty'=>'กรุณาเลือกโครงการ')) ?>

<?php echo $form->error($model,'project'); ?></td></tr>

<tr class="col-4"><th><?php echo $form->labelEx($model,'งบประมาณของลูกค้า*'); ?></th><td><?php echo $form->dropDownList($model,'budget', CHtml::listData(Budget::model()->findAll(), 'id', 'bud_name'), array('empty'=>'กรุณาเลือกงบประมาณ')) ?>
<?php echo $form->error($model,'budget'); ?></td></tr>

<tr class="odd"><th><?php echo $form->labelEx($model,'เบอร์โทรลูกค้า'); ?></th><td><?php echo $form->textField($model,'phone',array('size'=>15,'maxlength'=>15,'class' => 'col-6')); ?>
<?php echo $form->error($model,'phone'); ?></td></tr>

<tr class="even"><th><?php echo $form->labelEx($model,'รหัสบัตรประชาชนลูกค้า'); ?></th><td><?php echo $form->textField($model,'idcard',array('size'=>15,'maxlength'=>15,'class' => 'col-6')); ?>
<?php echo $form->error($model,'idcard'); ?></td></tr>

	</tbody></table>

	<div class="row buttons">
		<!-- <?php echo CHtml::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'Save'); ?> -->
		<?php echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-mini btn-info')); ?>
	</div>

<?php /*?>	<div class="row">
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
		<?php echo $form->dropDownList($model,'budget', CHtml::listData(Budget::model()->findAll(), 'id', 'bud_name'), array('empty'=>'กรุณาเลือกงบประมาณ')) ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'is_duplicate'); ?>
		<?php echo $form->textField($model,'is_duplicate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'is_duplicate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('row'=>5,'col'=>5)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div><?php */?>

<?php $this->endWidget(); ?>

</div><!-- form -->
