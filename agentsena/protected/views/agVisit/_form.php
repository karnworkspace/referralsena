<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */
/* @var $form CActiveForm */
?>

<div class="form container-fluid">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ag-visit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

		<table class="detail-view col-12" id="yw0"><tbody>
		<tr class="even">
			<th><?php echo $form->labelEx($model,'เลขนายหน้า'); ?></th>
			<td><?php echo $form->textField($model,'agent_id',array('value'=>Yii::app()->user->code_ref,'size'=>20,'readOnly'=>true,'maxlength'=>20,'class' => 'col-9')); ?><?php echo $form->error($model,'agent_id'); ?></td></tr>

		<tr class="odd"><th><?php echo $form->labelEx($model,'ชื่อ-สกุลลูกค้า'); ?></th>
			<td>	<?php
				if(isset($_GET["id"]) and $_GET["id"] != 0){
					$ag_id = $_GET["id"];

					echo CHtml::textField('cus-tmpname',JobFunction::GetCusName($ag_id),array('size'=>20,'readonly'=>'true','maxlength'=>20,'class' => 'col-9'));
					echo $form->hiddenField($model,'cus_id',array('value'=>$ag_id,'size'=>20,'maxlength'=>20,'class' => 'col-9'));


					//echo JobFunction::GetCusName($ag_id);

				}else{
					echo $form->dropDownList($model,'cus_id', CHtml::listData(AgCustomer::model()->findAll(array('condition'=>'is_duplicate="n" AND sena_approve="1" AND create_by="'.Yii::app()->user->id.'"', 'order' => 'fname ASC')), 'id', 'FullName'), array('empty'=>'กรุณาเลือกรายชื่อ','class' => 'col-9',
					 'ajax' => array(
					 'type'=>'POST', //request type
					 'url'=>CController::createUrl('agVisit/LoadProject'),
					 'update'=>'#AgVisit_project',
					 'data'=>array('user_id'=>'js:this.value'),
					)));
				}


				?></td></tr>

		<tr class="col-4"><th><?php echo $form->labelEx($model,'โครงการที่จะเยี่ยมชม'); ?></th>
        	<td>
            <?php
                if(isset($_GET["id"]) and $_GET["id"] != 0){
				$ag_id_project = $_GET["id"];
				$model_cus = AgCustomer::model()->findByPk($ag_id_project);

				$project_id = $model_cus->project;

					echo CHtml::textField('cus-tmpname',JobFunction::GetProjectName($project_id),array('size'=>20,'readonly'=>'true','maxlength'=>20,'class' => 'col-9'));
					echo $form->hiddenField($model,'project',array('value'=>$project_id,'size'=>20,'maxlength'=>20,'class' => 'col-9'));

				}else{

					echo $form->dropDownList($model,'project', array(), array('empty'=>'กรุณาเลือกโครงการ'));

				}



			 ?>
			<?php echo $form->error($model,'project'); ?>


            </td>
       </tr>

	<tr class="even">
    <th><?php echo $form->labelEx($model,'วันที่นัดหมาย'); ?></th>
    <td>
		<?php echo $form->textField($model,'visit_date',array('size'=>15,'maxlength'=>15,'class' => 'col-9','autocomplete'=>'off','data-provide'=>'datepicker','data-date-format'=>'yyyy-mm-dd')); ?>
        <?php echo $form->error($model,'visit_date'); ?>
    </td>
    </tr>

		</tbody>
        </table>

		<div class="row buttons">
			<!-- <?php echo CHtml::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'Save'); ?> -->
			<?php echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-mini btn-info')); ?>
		</div>


<!--
	<div class="row">
		<?php echo $form->labelEx($model,'agent_id'); ?>
		<?php echo $form->textField($model,'agent_id',array('value'=>Yii::app()->user->code_ref,'size'=>20,'readOnly'=>true,'maxlength'=>20,'class' => 'col-6')); ?>
		<?php echo $form->error($model,'agent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cus_id'); ?>
		<?php echo $form->textField($model,'cus_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cus_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project'); ?>
		<?php echo $form->dropDownList($model,'project', CHtml::listData(Project::model()->findAll(array('order' => 'project_name ASC')), 'id', 'project_name', 'project_type'), array('empty'=>'กรุณาเลือกโครงการ')) ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visit_date'); ?>
		<?php echo $form->textField($model,'visit_date',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'visit_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div> -->

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(document).ready(function () {
    $("#datePicker").datetimepicker({
        format: 'DD/MM/YYYY HH:mm:ss',
        defaultDate: new Date(),
    });
}
</script>
