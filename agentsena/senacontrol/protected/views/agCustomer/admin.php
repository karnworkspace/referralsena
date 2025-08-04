<?php
/* @var $this AgCustomerController */
/* @var $model AgCustomer */


$this->breadcrumbs=array(
	'Ag Customers'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List AgCustomer', 'url'=>array('index')),
//	array('label'=>'Create AgCustomer', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ag-customer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('#btn-reset').click(function(){
	location.reload();
	return false;
});

");
?>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    <!-- <div class="row"> -->
			<div class="view">
				    <div class="table-responsive">

<h1>รายการลูกค้าทั้งหมด</h1>

<div class="alert alert-success" role="alert">
  รายชื่อลูกค้าของนายหน้าจะแสดงผลตามสิทธิ์ที่ท่านดูแล
</div>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
));



?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ag-customer-grid',
	'dataProvider'=>$model->search(),
	// 'htmlOptions',
	// 'htmlOptions' => array('class' => 'table data-table table-bordered'),
	'columns'=>array(
		// array
    //     (
    //            	'header'=>'ชื่อ-สกุล นายหน้า',
		// 						'type'=>'raw',
    //             'value'=>function($data){
		// 			return JobFunction::GetAgentName($data->create_by);
		// 		},
		// ),
		// array
    //     (
    //            	'name'=>'agent_id',
		// 						'type'=>'raw',
    //             'value'=>function($data){
		// 				return JobFunction::GetAgentName($data->agent_id);
		// 				// return CHtml::encode($value_model->agent_id);
		// 		},
		// ),
		'fname',
		'lname',
		array
        (
               	'name'=>'project',
								'type'=>'raw',
                'value'=>function($data){
					return JobFunction::GetProjectName($data->project);
				},
		),
		//array
        //(
          //     	'name'=>'budget',
			//					'type'=>'raw',
             //   'value'=>function($data){
				//		$model_bud = Budget::model()->findByPk($data->budget);
				//		if($model_bud){
				//			return $model_bud->bud_name;
				//		}else{
				//			return "-";
				//		}
//
				//},
		//),
		//'phone',
	//array
     //  (
        //     	'name'=>'is_duplicate',
		//					'type'=>'raw',
         //       'value'=>function($data){
		//				if($data->is_duplicate == "y"){
		//					return "<a href=".Yii::app()->createUrl('agCustomer/duplicate',array("id"=>$data->id))." target='_blank'><b style=\"color:red;\">รายชื่อคล้ายกัน</b></a>";
		//				}else{
		//					return "<b style=\"color:green;\">ผ่าน</b>";
		//				}
		//		},
		//),
		array
        (
               	'name'=>'create_date',
								'type'=>'raw',
                'value'=>function($data){
						if($data->create_date){
							return DateThai::date_thai_convert_time($data->create_date,true);
						}
				},
		),

		array
        (
        'header'=>'อนุมัติ',
				'type'=>'raw',
        'value'=>function($data){
					if($data->sena_approve == 0){
							return "<b style=\"color:orange;\">รออนุมัติ</b>";
					}else{
						if($data->sena_approve == 1){

							return "<b style=\"color:green;\">ผ่าน</b>";
						}else{
							return "<b style=\"color:red;\">ไม่ผ่าน</b>";
						}
					}
				}
		),
		array
        (
        'header'=>'ผู้ทำรายการ',
				'type'=>'raw',
        'value'=>function($data){
					if($data->update_by != 0){
						$txt_sale_name = JobFunction::GetSaleEmail($data->update_by)." : ".DateThai::date_thai_convert_time($data->update_date,true);
					 		return $txt_sale_name;

					}else{
							return "";
					}

				}
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
<!-- </div> -->
</div>
</div></div>
