<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */

$this->breadcrumbs=array(
	'Ag Customers'=>array('view'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('index')),
// 	array('label'=>'Create AgCustomer', 'url'=>array('create')),
// 	//array('label'=>'Update AgCustomer', 'url'=>array('update', 'id'=>$model->id)),
// 	//array('label'=>'Delete AgCustomer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	//array('label'=>'Manage AgCustomer', 'url'=>array('admin')),
);
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">ข้อมูลลูกค้า</a></li>
    <li class="breadcrumb-item active" aria-current="page">ข้อมูลลูกค้า <?php echo $model->fname; ?> <?php echo $model->lname; ?></li>
  </ol>
</nav>
<h1>รายละเอียดลูกค้า <?php echo $model->fname; ?> <?php echo $model->lname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'agent_id',
		'fname',
		'lname',
		array
        (
                'name'=>'project',
                'value'=>function($data){
					$project_id = Project::model()->findBYPk($data->project);
					if($project_id){
						return $project_id->project_name;
					}
				},
        ),

		// array
    //     (
    //             'name'=>'project',
    //             'value'=>function($data){
		// 			$project_id = Project::model()->findByPk($id);
		// 			if($project_id){
		// 				return $project_id->project_name;
		// 			}
		// 		},
		// 	),
			array
	        (
	                'name'=>'budget',
	                'value'=>function($data){
						$model_bud = Budget::model()->findByPk($data->budget);
						if($model_bud){
							return $model_bud->bud_name;
						}
					}
				),
		// 'project' = > JobFunction::GetProjectName($data->project),
		// 'budget',
		'phone',
		'idcard',
		// 'is_duplicate',
		// 'duplicate_lead_id',
		'create_date',
		// 'user_ip',
	),
	


	

)); ?>
