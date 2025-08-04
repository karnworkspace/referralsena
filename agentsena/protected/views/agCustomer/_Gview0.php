<?php
/* @var $this AgCustomerController */
/* @var $data AgCustomer */
$this->pageTitle=Yii::app()->name;
?>
<div class="view">
	<div class="container-fluid">
	    <div class="table-responsive">
	        <table class="table data-table" id="resdiv" class="table" cellspacing="0" width="100%">

	  <thead class="table-dark">
	    <tr>
				<th scope="col">วันที่</th>
	      <th scope="col">เลขนายหน้า</th>
	      <th scope="col">ชื่อลูกค้า</th>
	      <th scope="col">สกุลลูกค้า</th>
	      <th scope="col">โครงการที่ลูกค้าสนใจ</th>
				<th scope="col">งบประมาณของลูกค้า</th>
				<th scope="col">เบอร์โทรลูกค้า</th>
				<th scope="col">รหัสบัตรประชาชนลูกค้า</th>
				<th scope="col">ผลการตรวจสอบ</th>
				<th scope="col">เจ้าหน้าที่ตรวจสอบ</th>
				<th scope="col">ยืนคำร้อง</th>
	    </tr>
	  </thead>
	  <tbody>

	<tr class="<?php echo CHtml::encode($data->id); ?>">
				<th scope="row"><?=DateThai::date_thai_convert_time($data->create_date,true)?></th>
				<td><h3><a href="<?=Yii::app()->createUrl('agCustomer/view/',array('id'=>$data->id))?>"><span class="badge badge-success"><?php echo CHtml::encode($data->agent_id); ?></span></a></h3></td>
				<td><?php echo CHtml::encode($data->fname); ?></td>
				<td><?php echo CHtml::encode($data->lname); ?></td>
				<td><?=JobFunction::GetProjectName($data->project)?></td>
				<td><?=JobFunction::GetBudget($data->budget)?></td>
				<td><?php echo CHtml::encode($data->phone); ?></td>
				<td><?php echo CHtml::encode($data->idcard); ?></td>
				<td><strong><?php if(CHtml::encode($data->is_duplicate)=='y'){ echo "<span style='color: green;' />ผ่าน</span>"; }else {
					echo "<span style='color: red;' />ไม่ผ่าน</span>";
				}?></strong></td>
				<td><strong><?php if(CHtml::encode($data->sena_approve)==0){ echo "<span style='color: red;' />รอพิจารณา</span>"; }else {
					echo "<span style='color: green;' />ผ่านการตรวจสอบ</span>";
				}?></strong></td>
				<td><strong><?php if(CHtml::encode($data->is_duplicate)=='n'){?><a href="<?=Yii::app()->createUrl('agRequest/create/',array('id'=>$data->id))?>"><button type="button" class="btn btn-mini btn-block btn-danger">ขอยื่นคำร้อง</button></a><?php } ?></strong></td>
					<!-- <td><strong><?php if(CHtml::encode($data->is_duplicate)=='n'){?><button type="button" class="btn btn-mini btn-block btn-info" data-toggle="modal<?php echo CHtml::encode($data->id); ?>" data-target=".bd-example-modal-sm">ยืนคำร้อง</button><?php } ?></td> -->
	    </tr>

	  </tbody>
	</table>
</div></div></div>


<?php /*

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_id')); ?>:</b>
	<?php echo CHtml::encode($data->agent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fname')); ?>:</b>
	<?php echo CHtml::encode($data->fname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lname')); ?>:</b>
	<?php echo CHtml::encode($data->lname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project')); ?>:</b>
	<?php echo CHtml::encode($data->project); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sena_approve')); ?>:</b>
	<?php echo CHtml::encode($data->sena_approve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('idcard')); ?>:</b>
	<?php echo CHtml::encode($data->idcard); ?>
	<br />

	*/ ?>

</div>
<!-- <script>
$(document).ready(function() {
    var table = $('#resdiv').DataTable();
} );
</script>
<style>
.table-responsive {
  overflow-x: inherit;
}
</style> -->
