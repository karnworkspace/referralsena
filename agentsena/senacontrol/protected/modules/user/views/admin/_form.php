<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
				<?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'user-form',
                    'enableAjaxValidation'=>true,
                    'htmlOptions' => array('enctype'=>'multipart/form-data'),
                ));
                ?>        
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $header = ($model->isNewRecord) ? UserModule::t("เพิ่มข้อมูลพนักงาน") : UserModule::t('แก้ไขข้อมูลพนักงาน')." ".$model->id.'</i>'; ?></h4>
                        
<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>                    
                        <?php echo $form->errorSummary(array($model,$profile)); ?>
                        
                        
                        <div class="form-group row">
                            	<?php echo $form->labelEx($model,'username',array("class"=>"col-sm-3 text-right control-label col-form-label")); ?>
                            <div class="col-sm-9">
                                <?php echo $form->textField($model,'username',array('class'=>'form-control','size'=>60,'maxlength'=>100)); ?>
                                <?php echo $form->error($model,'username'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                        		<?php echo $form->labelEx($model,'password',array("class"=>"col-sm-3 text-right control-label col-form-label")); ?>
                            <div class="col-sm-9">
                            <?php echo $form->passwordField($model,'password',array('class'=>'form-control','size'=>60,'maxlength'=>128)); ?>
                                <?php echo $form->error($model,'password'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group row">
							<?php echo $form->labelEx($model,'email',array("class"=>"col-sm-3 text-right control-label col-form-label")); ?>
                            <div class="col-sm-9">
                            	<?php echo $form->textField($model,'email',array('class'=>'form-control','size'=>60,'maxlength'=>100)); ?>
                                <?php echo $form->error($model,'email'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
							<?php echo $form->labelEx($model,'superuser',array("class"=>"col-sm-3 text-right control-label col-form-label")); ?>
                            <div class="col-sm-9">
 								<?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>'select2 form-control custom-select')); ?>								
                                <?php echo $form->error($model,'superuser'); ?>
                            </div>
                        </div>
                        
                        
                        
                        
					<?php 
                            $profileFields=$profile->getFields();
                            if ($profileFields) {
                                foreach($profileFields as $field) {
                                ?>
                        <div class="form-group row">
                            <?php echo $form->labelEx($profile,$field->varname,array("class"=>"col-sm-3 text-right control-label col-form-label")); ?>
                            <?php 
                            if ($widgetEdit = $field->widgetEdit($profile)) {
                                echo "<div class=\"col-sm-9\">".$widgetEdit."</div>";
                            } elseif ($field->range) {
                                echo "<div class=\"col-sm-9\">".$form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'form-control'))."</div>";
							} elseif ($field->varname == "department") {
                                 echo "<div class=\"col-sm-9\">".$form->dropDownList($profile,$field->varname,CHtml::listData(Department::model()->department_order()->findAll('depart_st = "y"'), 'depart_id', 'depart_name'), array('empty'=>'-- กรุณาเลือก แผนก / ฝ่าย --','class'=>'select2 form-control custom-select'))."</div>";
							} elseif ($field->varname == "team") {
                                 echo "<div class=\"col-sm-9\">".$form->dropDownList($profile,$field->varname,CHtml::listData(MarcomTeam::model()->team_order()->findAll(), 'team_id', 'team_name'), array('empty'=>'-- กรุณาเลือก ทีม --','class'=>'select2 form-control custom-select'))."</div>";	 
                            } elseif ($field->field_type=="TEXT") {
                                echo "<div class=\"col-sm-9\">".CHtml::activeTextArea($profile,$field->varname,array('class'=>'form-control','rows'=>6, 'cols'=>50))."</div>";
                            } else {
                                echo "<div class=\"col-sm-9\">".$form->textField($profile,$field->varname,array('class'=>'form-control','size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)))."</div>";
                            }
                             ?>
                            <?php echo "<div class=\"col-sm-9\">".$form->error($profile,$field->varname)."</div>"; ?>
                        </div>
                                <?php
                                }
                            }
                    ?>
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                                                    
                    </div>
                    
               <div class="border-top text-center">
					<div class="card-body">
                        
				<?php
                    echo CHtml::tag('button', array(
                        'name'=>'btnSubmit',
                        'type'=>'submit',
                        'class'=>'btn btn-default',
                    ), ($model->isNewRecord ? "Create" : "Update"));
                ?>                    
            

                        </div>
                    </div>
				<?php $this->endWidget(); ?>                
            </div>
  

        </div>
    </div>
    <!-- editor -->
    
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<script type="text/javascript">
(function($){
	

})(jQuery); 
</script>