<?php
/* @var $this AgLeadController */
/* @var $model AgLead */
/* @var $form CActiveForm */
?>

<!-- <div class="container-fluid"> -->
<!-- <div class="container-fluid"> -->
<div class="wide form">
<div class="row">
<h3>ค้นหารายชื่อ Lead</h3>
</div>
<div class="alert alert-success" role="alert">
  กรุณาค้นหาจากระบบ CRM หลัก, ไฟล์เอกสาร, Sheet ต่างๆ ของท่านประกอบการตัดสินใจ
</div>
</div>
<div class="container-fluid alert-success">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'fname'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'fname',array('size'=>50,'maxlength'=>90)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lname'); ?>
	</div>
	<div class="row">
		<?php echo $form->textField($model,'lname',array('size'=>50,'maxlength'=>90)); ?>
	</div>

<br />
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::resetButton('Reset',array('id'=>'btn-reset')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- </div> -->
<!-- search-form -->
