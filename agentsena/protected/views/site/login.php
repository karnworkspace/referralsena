<?php
//$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
//$this->breadcrumbs=array(
//	UserModule::t("Login"),
//);
?>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center ">
    <div class="auth-box bg-dark border-secondary">
        <div id="loginform">
          <div class="logo-icon p-l-10 text-center">
			         <img src="/agentsena/themes/admin-marcom/themes/images/FGF-senahappy-refer-logo.png" alt="logo" class="light-logo" style="width:120px;"/>
			             <!--  <img src="/agentsena/themes/admin-marcom/themes/images/sena-logo.png" alt="logo" class="light-logo" />  -->
          </div>
            <div class="text-center p-t-10 p-b-20">
                <span class="db" style="color:#FFF !important;"><h1>เข้าสู่ระบบ SENA HAPPY REFER</h1></span>
                <span class="db" style="color:#FFF !important;"><small>กรุณา Login เข้าสู่ระบบ เพื่อทำรายการของท่าน</small></span>
            </div>

		<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
            <!-- Form -->
                <div class="row p-b-20">
                    <div class="col-12">
                      <span style="color:#FFF !important;"></span>
                        <div class="input-group mb-3">
		<?php //echo $form->labelEx($model,'ID CARD'); ?>
		<?php echo $form->textField($model,'idcard',array('class'=>'form-control form-control-lg','placeholder'=>'ID CARD','max-length'=>15)); ?>
		<?php echo $form->error($model,'idcard'); ?>
								<?php //echo CHtml::activeTextField($model,'username',array('class'=>'form-control form-control-lg','placeholder'=>'Username','aria-label'=>'Username','aria-describedby'=>'basic-addon1','autofocus')) ?>     <!--<input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">-->
                        </div>
                      <span style="color:#FFF !important;"></span>
                      <div class="input-group mb-3">
              <?php //echo $form->labelEx($model,'E mail'); ?>
                              <?php echo $form->textField($model,'email',array('class'=>'form-control form-control-lg','placeholder'=>'E-MAIL')); ?>
                              <?php echo $form->error($model,'email'); ?>

              <?php //echo CHtml::activePasswordField($model,'password',array('class'=>'form-control form-control-lg','placeholder'=>'Password','aria-label'=>'Username','aria-describedby'=>'basic-addon1')) ?>
                          <!--<input type="text" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">-->
                      
                      </div>
                        
                        <span style="color:#FFF !important;"><center><small>[ e-mail ต้องเป็นตัวพิมพ์เล็กทั้งหมด ] <br />หากเข้าระบบไม่ได้ กรุณาติดต่อ Email : <a href="mailto:psd.happyrefer@gmail.com" style="color:#fff;">psd.happyrefer@gmail.com</a><br>หรือ โทร 025414642 #10411</small></span>
                    </div>
                </div>
                    <div class="col-12">
                                <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-success btn-block float-right')); ?>
                    </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>
