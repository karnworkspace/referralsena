<?php
/* @var $this AgCustomerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Customers',
);

// $this->menu=array(
// 	array('label'=>'เพิ่มรายชื่อลูกค้า', 'url'=>array('create')),
// 	//array('label'=>'Manage AgCustomer', 'url'=>array('admin')),
// );
?>
<div class="container-fluid">
<h1>รายการลูกค้าของท่าน</h1>
	<div class="alert alert-success" role="alert">
  เพิ่มข้อมูลรายชื่อผู้ถูกแนะนำของท่านเพื่อให้เสนาฯ ตรวจสอบข้อมูล
</div>
<!-- <div class="alert alert-success" role="alert">
  เพิ่มข้อมูลรายชื่อลูกค้าของท่านเพื่อให้เสนาฯ ตรวจสอบข้อมูล โดยระยะเวลาลูกค้าจะต้องไม่เคยเป็นผู้เข้าเยี่ยมชมโครงการ หรือลงทะเบียนบนเว็บไซต์ตั้งแต่ 1 ธันวาคม 2563- ปัจจุบัน
</div>-->
<div class="p-b-30" style="margin-bottom:10px;"><a href="<?php echo Yii::app()->createUrl('agCustomer/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i> เพิ่มรายชื่อลูกค้า</span></a></div>
<div class="view">
	<div class="container-fluid">
	    <div class="table-responsive">
	        <table class="table data-table table-bordered" id="resdiv" class="table" cellspacing="0" width="100%">

	  <thead class="table-dark">
	    <tr>
				<th scope="col">วันที่เพิ่มข้อมูล</th>
	      <th scope="col">เลขนายหน้า</th>
	      <th scope="col">ชื่อ-สกุลลูกค้า</th>
		  <th scope="col">เบอร์โทร</th>
	      <th scope="col">โครงการที่สนใจ</th>
				<!-- <th scope="col">งบประมาณ</th> -->
				<!-- <th scope="col">เบอร์โทร</th> -->
				<!-- <th scope="col">บัตรประชาชน</th> -->
				<!-- <th scope="col">ผลตรวจสอบ</th> -->
				<th scope="col">สถานะตรวจสอบ</th>
				<!--<th scope="col">Action</th>-->
	    </tr>
	  </thead>
	  <tbody>

<?php
foreach($model as $key_model => $value_model){
	// $datetime = new DateTime(CHtml::encode($value_model->create_date));
	// $datetime->modify('+1 day');
	// echo $datetime->format('Y-m-d H:i:s');
?>
	<tr class="<?php echo CHtml::encode($value_model->id); ?>">
				<th scope="row"><?=DateThai::date_thai_convert_time($value_model->create_date,true)?></th>
				<td><h3><a href="<?=Yii::app()->createUrl('agCustomer/view/',array('id'=>$value_model->id))?>"><span class="badge badge-success"><?php echo CHtml::encode($value_model->agent_id); ?></span></a></h3></td>
				<td><?php echo CHtml::encode($value_model->fname); ?> <?php echo CHtml::encode($value_model->lname); ?></td>
		       <td><?php echo CHtml::encode($value_model->phone); ?></td>
				<td><?=JobFunction::GetProjectName($value_model->project)?></td>
				<!-- <td><?=JobFunction::GetBudget($value_model->budget)?></td> -->
				<!-- <td><?php echo CHtml::encode($value_model->phone); ?></td> -->
				<!-- <td><?php echo CHtml::encode($value_model->idcard); ?></td> -->
				<!-- <td><strong><?php if(CHtml::encode($value_model->is_duplicate)=='y'){ echo "<span style='color: red;' /><small>ไม่ผ่านการตรวจสอบเบื้องต้น
เนื่องจากรายชื่อลูกค้าท่านนี้เคยสนใจโครงการของเสนา</small></span>"; }else {
					echo "<span style='color: green;' />ผ่าน</span> <small>*แบบมีเงื่อนไข</small>";
				}?></strong></td> -->
				<!-- <td><strong><?php if(CHtml::encode($value_model->sena_approve)==0){ echo "<span style='color: red;' />รอดำเนินการตรวจสอบภายใน 2 วัน</span>"; }else if(CHtml::encode($value_model->sena_approve)==2) {	echo "<span style='color: red;' />ไม่ผ่านการตรวจสอบ เนื่องจากรายชื่อลูกค้าท่านนี้เคยสนใจโครงการของเสนาตั้งแต่ 1 ธันวาคม 2562 - ปัจจุบัน</span>"; }else {
					echo "<span style='color: green;' />ผ่านการตรวจสอบ</span>";
				}?></strong> </td>-->
                <td><strong><?php if(CHtml::encode($value_model->sena_approve)==0){ echo "<span style='color: red;' />รอดำเนินการตรวจสอบ</span>"; }else if(CHtml::encode($value_model->sena_approve)==2) {	echo "<span style='color: red;' />ขออภัย ผู้ที่ท่านแนะนำ ซ้ำกับรายชื่อของฐานข้อมูลโครงการ</span>"; }else {
					echo "<span style='color: green;' />ผู้ถูกแนะนำของท่านผ่านเงื่อนไข</span>";
				}?></strong> </td>
			<!--	<td><strong>
					<?php if(CHtml::encode($value_model->sena_approve)==0){?><button type="button" class="btn btn-mini btn-block btn-danger">กำลังดำเนินการ</button><?php }else if(CHtml::encode($value_model->sena_approve)==2){ ?><a href="<?=Yii::app()->createUrl('agRequest/create/',array('id'=>$value_model->id))?>"><button type="button" class="btn btn-mini btn-block btn-info">ยื่นคำร้อง</button></a> <?php } else { ?><a href="<?=Yii::app()->createUrl('agVisit/create/',array('id'=>$value_model->id))?>"><button type="button" class="btn btn-mini btn-block btn-warning" style="color:#000;">คลิ๊กเพื่อนัดหมายเยี่ยมชมโครงการ</button></a><?php } ?></strong></td> -->
					<!-- <td><strong><?php if(CHtml::encode($value_model->is_duplicate)=='n'){?><button type="button" class="btn btn-mini btn-block btn-info" data-toggle="modal<?php echo CHtml::encode($value_model->id); ?>" data-target=".bd-example-modal-sm">ยืนคำร้อง</button><?php } ?></td> -->
	    </tr>
<?php
}
?>

	  </tbody>
	</table>
</div></div></div></div>

<?php //$this->widget('zii.widgets.CGridView', array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_Gview',
	//'viewData'=>array('dataProvider'=>$dataProvider),
//)); ?>
<script>
$(document).ready(function() {
    var table = $('#resdiv').DataTable();
} );
</script>
<style>
/* .table-responsive {
  overflow-x: inherit;
} */
</style>
