<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */

$this->breadcrumbs=array(
	'Ag Visits'=>array('index'),
	'Create',
);

// $this->menu=array(
// 	array('label'=>'List AgVisit', 'url'=>array('index')),
// 	array('label'=>'Manage AgVisit', 'url'=>array('admin')),
// );
?>
<div class="container-fluid">
<h1>เพิ่มการนัดหมายเยี่ยมชมโครงการ</h1>
<div class="alert alert-success" role="alert">
ระบุข้อมูลลูกค้าที่ผ่านการตรวจสอบจาก [<a href="<?php echo Yii::app()->createUrl('AgCustomer/');?>">ข้อมูลลูกค้า</a>] พร้อมระบุวันที่ โครงการที่ต้องการนัดหมายเข้าเยี่ยมชม โดยนายหน้าจะต้องนำลูกค้าเข้าเยี่ยมชมโครงการด้วยตัวท่านเองทุกครั้ง
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
