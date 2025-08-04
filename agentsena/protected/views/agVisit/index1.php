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
<a href="<?php echo Yii::app()->createUrl('agVisit/create');?>"><span class="btn btn-success btn-large"><i class="fa fa-plus-square"></i>เพิ่มการนัดหมาย</span></a>
<h1>รายการนัดหมายเยี่ยมชมโครงการ</h1>

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
				<td><?php echo CHtml::encode($value_model->status); ?></td>
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
.table-responsive {
  overflow-x: inherit;
}
</style>
