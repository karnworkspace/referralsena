<div class="container-fluid">
<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	$model->username,
);


$this->menu=array(
    //array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
   // array('label'=>UserModule::t('Update User'), 'url'=>array('update','id'=>$model->id)),
    //array('label'=>UserModule::t('Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    //array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);
?>
<h4><?php echo UserModule::t('ข้อมูลพนักงาน').' "'.$model->username.'"'; ?></h4>

<?php
 
	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			if($field->varname == "department"){
				$txt_department = JobFunction::GetDepartName($model->profile->getAttribute($field->varname));
				array_push($attributes,array(
						'label' => UserModule::t($field->title),
						'name' => $field->varname,
						'type'=>'raw',
						'value' => $txt_department,
					));
				
			}else if($field->varname == "team"){
				$txt_team = JobFunction::GetMarcomTeamName($model->profile->getAttribute($field->varname));
				array_push($attributes,array(
						'label' => UserModule::t($field->title),
						'name' => $field->varname,
						'type'=>'raw',
						'value' => $txt_team,
					));
			}else if($field->varname == "is_show"){
				if($model->profile->getAttribute($field->varname) == "y"){
					$txt_is_show = "Yes";
				}else{
					$txt_is_show = "No";
				}
				
				array_push($attributes,array(
						'label' => UserModule::t($field->title),
						'name' => $field->varname,
						'type'=>'raw',
						'value' => $txt_is_show,
					));
			}else{
				array_push($attributes,array(
						'label' => UserModule::t($field->title),
						'name' => $field->varname,
						'type'=>'raw',
						'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
					));
			}
		}
	}
	
	array_push($attributes,
		'password',
		'email',
		'activkey',
		'create_at',
		'lastvisit_at',
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
</div>