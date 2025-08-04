<?php
/* @var $this AgVisitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Visits',
);

// $this->menu=array(
// 	array('label'=>'Create AgVisit', 'url'=>array('create')),
// 	array('label'=>'Manage AgVisit', 'url'=>array('admin')),
// );
?>
<!-- <a href="<?php echo Yii::app()->createUrl('agVisit/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i>เพิ่มการนัดหมาย</span></a> -->
<h1>รายการนัดหมายเยี่ยมชมโครงการ</h1>
<div class="alert alert-success" role="alert">
  เพื่ออำนวยความสะดวกแก่ท่านและลูกค้า โปรดแจ้งวัน-เวลา สถานที่นัดหมายเยี่ยมชมโครงการแก่เสนาฯ
</div>
<div class="p-b-30" style="margin-bottom:10px;"><a href="<?php echo Yii::app()->createUrl('agVisit/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i>  เพิ่มการนัดหมายกับเสนาฯ</span></a></div>
<div class="view">
	<div class="container-fluid">
	    <div class="table-responsive">
	        <table class="table data-table table-bordered" id="resdiv" class="table" cellspacing="0" width="100%">

	  <thead class="table-dark">
	    <tr>
				<th scope="col">วันที่เพิ่มข้อมูล</th>
	      <th scope="col">เลขนายหน้า</th>
	      <th scope="col">ชื่อ-สกุลลูกค้า</th>
	      <th scope="col">โครงการที่นัดหมาย</th>
				<th scope="col">วัน-เวลาที่นัดหมาย</th>
				<th scope="col">สถานะลูกค้า</th>
	    </tr>
	  </thead>
	  <tbody>

<?php
foreach($model as $key_model => $value_model){
?>
	<tr class="<?php echo CHtml::encode($value_model->id); ?>">
				<th scope="row"><?=DateThai::date_thai_convert_time($value_model->create_date,true)?></th>
				<td><h3><a href="<?=Yii::app()->createUrl('agVisit/view/',array('id'=>$value_model->id))?>"><span class="badge badge-success"><?php echo CHtml::encode($value_model->agent_id); ?></span></a></h3></td>
				<td><?=JobFunction::GetCusName($value_model->cus_id)?></td>
				<td><?=JobFunction::GetProjectName($value_model->project)?></td>
				<td><?=DateThai::date_thai_convert_time($value_model->visit_date,true)?></td>
				<td><strong><?php if(CHtml::encode($value_model->status)=='0'){?><button type="button" class="btn btn-mini btn-block btn-danger" data-toggle="popover" data-placement="top" title="รอการตรวจสอบ คืออะไร?" data-content="จะถูกอัพเดทสถานะอีกครั้งเมื่อลูกค้าทำการโอนห้อง/ยูนิต">รอการตรวจสอบ</button><?php }else if(CHtml::encode($value_model->status)=='1'){  ?><button type="button" class="btn btn-mini btn-block btn-success">ยืนยันการจองแล้ว</button><?php } ?></strong></td>
	    </tr>
<?php
}
?>
<!-- <button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button> -->

	  </tbody>
	</table>
</div></div></div>


<script>
$(document).ready(function() {
    var table = $('#resdiv').DataTable();
} );
</script>
<style>
.table-responsive {
  overflow-x: inherit;
}
.datepicker td, .datepicker th {
	font-size: 16px!important;
}
</style>
