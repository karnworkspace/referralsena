<?php
/* @var $this AgRequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ag Requests',
);
//
// $this->menu=array(
// 	array('label'=>'Create AgRequest', 'url'=>array('create')),
// 	array('label'=>'Manage AgRequest', 'url'=>array('admin')),
// );
?>
<!-- <a href="<?php echo Yii::app()->createUrl('agRequest/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i>เพิ่มคำร้องใหม่</span></a> -->
<div class="container-fluid">
<h1>รายการยื่นคำร้อง</h1>
<div class="alert alert-success" role="alert">
 กรณีลูกค้าที่ท่านไม่สามารถเพิ่มรายชื่อเข้าระบบได้ ท่านสามารถแจ้งให้เจ้าหน้าที่ตรวจสอบข้อมูลได้
</div>
<div class="p-b-30" style="margin-bottom:10px;"><a href="<?php echo Yii::app()->createUrl('agRequest/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i> ยื่นคำร้องใหม่</span></a></div>

<div class="view">
		<div class="table-responsive">
	<table class="table data-table table-bordered" id="resdiv" class="table" cellspacing="0" width="100%">
	  <thead class="table-dark">
	    <tr>
				<th scope="col">วันที่เพิ่มข้อมูล</th>
	      <th scope="col">เลขนายหน้า</th>
	      <th scope="col">ชื่อ-สกุลลูกค้า</th>
	      <th scope="col">รายละเอียดคำร้อง</th>
				<th scope="col">สถานะ</th>
	    </tr>
	  </thead>
	  <tbody>

      <?php
	  foreach($model as $key_model => $value_model){
	  ?>
	    <tr>
				<th scope="row"><?php echo CHtml::encode(DateThai::date_thai_convert_time($value_model->create_date,true)); ?></th>
				<td><h3><span class="badge badge-success"><?php echo CHtml::encode($value_model->agent_id); ?></span></h3></td>
				<td><?php echo CHtml::encode(JobFunction::GetCusName($value_model->cus_id)); ?></td>
				<td><?php echo CHtml::encode($value_model->comment); ?></td>
				<td>
				<strong>
				<?php
				$prove_st = JobFunction::GetProveSt($value_model->cus_id);

				if($prove_st == 0){ ?>
					<button type="button" class="btn btn-mini btn-block btn-danger" data-toggle="popover" data-placement="top" title="รอการตรวจสอบ คืออะไร?" data-content="เจ้าหน้าที่ของเราจะใช้เวลาในการพิจารารายการของท่าน 1-3 วันทำการ">รอการตรวจสอบ</button><!-- echo "<span style='color: red;' />รอพิจารณา</span>"; -->
			<?php }else {?>
				<button type="button" class="btn btn-mini btn-block btn-success" data-toggle="popover" data-placement="top"  title="รอการตรวจสอบ คืออะไร?" data-content="เจ้าหน้าที่พิจารณาข้อมูลของท่านเรียบร้อยแล้ว">ผ่านการตรวจสอบ</button>
					<!-- echo "<span style='color: green;' />ผ่านการตรวจสอบ</span>"; -->
				<?php } ?>
                </strong>
                </td>

	    </tr>
        <?php
	  }
		?>

	  </tbody>
	</table>

</div></div></div>
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
