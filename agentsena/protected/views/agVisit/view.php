<?php
/* @var $this AgVisitController */
/* @var $model AgVisit */

$this->breadcrumbs=array(
	'Ag Visits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('index')),
// 	array('label'=>'Create AgVisit', 'url'=>array('create')),
// 	array('label'=>'Update AgVisit', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete AgVisit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage AgVisit', 'url'=>array('admin')),
);
?>
<div class="container-fluid">
<h1>รายการนัดหมาย #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'agent_id',
		array
        (
                'name'=>'cus_id',
                'value'=>function($data){
						return JobFunction::GetCusName($data->cus_id);
				},
        ),
		array
        (
                'name'=>'project',
                'value'=>function($data){
						return JobFunction::GetProjectName($data->project);
				},
        ),
		array
        (
                'name'=>'visit_date',
                'value'=>function($data){
						return DateThai::date_thai_convert($data->visit_date,false);
				},
        ),
	),
)); ?>
</div>
