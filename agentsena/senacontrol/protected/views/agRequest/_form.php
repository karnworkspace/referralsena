<?php
/* @var $this AgRequestController */
/* @var $model AgRequest */
/* @var $form CActiveForm */


?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ag-request-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

				<div class="alert alert-success" role="alert">
				  ยื่นขอพิจารณารายชือลูกค้าใหม่ [<a href="<?php echo Yii::app()->createUrl('agRequest/');?>">ตรวจสอบรายชื่อที่เคยยื่น</a>]
				</div>

	<table class="detail-view col-12"><tbody>
	<tr class="col-6">
		<th><?php echo $form->labelEx($model,'เลขนายหน้า'); ?></th>
		<td><?php echo $form->textField($model,'agent_id',array('value'=>Yii::app()->user->code_ref,'size'=>20,'readonly'=>'true','maxlength'=>20,'class' => 'col-6')); ?><?php echo $form->error($model,'agent_id'); ?></td></tr>

	<tr class="col-6"><th><?php echo $form->labelEx($model,'ชื่อลูกค้า'); ?></th>
		<td>
		<?php 
		if(isset($_GET["id"]) and $_GET["id"] != 0){
			$ag_id = $_GET["id"];
			
			echo CHtml::textField('cus-tmpname',JobFunction::GetCusName($ag_id),array('size'=>20,'readonly'=>'true','maxlength'=>20,'class' => 'col-6'));
			echo $form->hiddenField($model,'cus_id',array('value'=>$ag_id,'size'=>20,'maxlength'=>20,'class' => 'col-6'));
			
			
			//echo JobFunction::GetCusName($ag_id);
			
		}else{
			echo $form->dropDownList($model,'cus_id', CHtml::listData(AgCustomer::model()->findAll(array('condition'=>'is_duplicate="y" AND create_by="'.Yii::app()->user->id.'" AND sena_approve = 0', 'order' => 'fname ASC')), 'id', 'FullName'), array('empty'=>'กรุณาเลือกรายชื่อ','class' => 'col-6'));
		}

		
		?>
        </td>

	<tr class="col-12"><th><?php echo $form->labelEx($model,'รายละเอียด'); ?></th><td><?php echo $form->textArea($model,'comment',array('size'=>50,'minlength'=>2,'maxlength'=>50,'class' => 'col-12','rows' => 10,'cols' => 50)); ?>
		<p class="col-12"><small>ให้รายละเอียดเพิ่มเติมเกี่ยวกับลูกค้าท่านนี้ ให้เจ้าหน้าที่ของเราได้พิจารณา</small></p>
	<?php echo $form->error($model,'comment'); ?>
</td></tr>


	</tbody></table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-mini btn-info')); ?>

	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->
