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
              <img src="/agentsena/themes/admin-marcom/themes/images/sena-logo.png" alt="logo" class="light-logo" />
          </div>
            <div class="text-center p-t-10 p-b-20">
                <span class="db" style="color:#FFF !important;"><h1>เข้าสู่ระบบ ADMIN</h1></span>
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
        <span class="input-group-btn">
            <button class="btn btn-success" type="button"><i class="fa fa-user"></i></button>
      </span> 

		<?php echo $form->textField($model,'username',array('class'=>'form-control form-control-lg','placeholder'=>'Username','max-length'=>15)); ?>

		<?php echo $form->error($model,'username'); ?>
								<?php //echo CHtml::activeTextField($model,'username',array('class'=>'form-control form-control-lg','placeholder'=>'Username','aria-label'=>'Username','aria-describedby'=>'basic-addon1','autofocus')) ?>     <!--<input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">-->
                        </div>
                      <span style="color:#FFF !important;"></span>
                      <div class="input-group mb-3">
              <?php //echo $form->labelEx($model,'E mail'); ?>
                              <span class="input-group-btn">
                              		<button class="btn btn-success reveal" type="button"><i class="fa fa-eye-slash"></i></button>
                              </span> 
                              <?php echo $form->passwordField($model,'password',array('class'=>'form-control form-control-lg pwd','placeholder'=>'Password')); ?>
                              <?php echo $form->error($model,'password'); ?>

              <?php //echo CHtml::activePasswordField($model,'password',array('class'=>'form-control form-control-lg','placeholder'=>'Password','aria-label'=>'Username','aria-describedby'=>'basic-addon1')) ?>
                          <!--<input type="text" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">-->
                      </div>

                        <span style="color:#FFF !important;"><small>หากเข้าระบบไม่ได้ กรุณาติดต่อ Email : psd.happyrefer@gmail.com <br>หรือ  โทร 025414642 #10411</small></span>
                    </div>
                </div>
                    <div class="col-12">
                                <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-success btn-block float-right')); ?>
                    </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>
<script type="text/javascript">
$( document ).ready(function() {
	$(".reveal").on('click',function() {
		var $pwd = $(".pwd");
		if ($pwd.attr('type') === 'password') {
			$pwd.attr('type', 'text');
			$('.reveal i').removeClass( "fa-eye-slash" );
            $('.reveal i').addClass( "fa-eye" );
		} else {
			$pwd.attr('type', 'password');
			$('.reveal i').addClass( "fa-eye-slash" );
		}
	});
});

</script>