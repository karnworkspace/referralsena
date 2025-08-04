<?php
//$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
//$this->breadcrumbs=array(
//	UserModule::t("Login"),
//);
?>

<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
    <div class="auth-box bg-dark border-top border-secondary">
        <div id="loginform">
            <div class="text-center p-t-20 p-b-20">
                <span class="db" style="color:#FFF !important;"><?php echo UserModule::t("Login"); ?></span>
            </div>
            
			<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

            <div class="success">
                <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
            </div>
            
            <?php endif; ?>
            
            <!-- Form -->
            <?php echo CHtml::beginForm('','post',array('class'=>'form-horizontal m-t-20','id'=>'loginform')); ?>
            <?php echo '<span class="db" style="color:#FFF !important;">'.CHtml::errorSummary($model).'</span>'; ?>
            
                <div class="row p-b-30">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                            </div>
								<?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control form-control-lg','placeholder'=>'Username','aria-label'=>'Username','aria-describedby'=>'basic-addon1','autofocus')) ?>     <!--<input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">-->
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                            </div>
								<?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control form-control-lg','placeholder'=>'Password','aria-label'=>'Username','aria-describedby'=>'basic-addon1')) ?>                            
                            <!--<input type="text" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">-->
                        </div>
                        <div class="input-group mb-3">
                        <span class="db" style="color:#FFF !important;">
							<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                            <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
                        </span>
                        </div>
                        
                        <div class="input-group mb-3">
                        <span class="db" style="color:#FFF !important;">กรณีไม่สามารถเข้าสู่ระบบได้ ติดต่อ MARCOM #10833</span>
                        </div>

                    </div>
                </div>
                <div class="row border-top border-secondary">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="p-t-20">
                                <a href="<?=Yii::app()->createUrl("register/create")?>"><button class="btn btn-info" id="to-regis" type="button"><i class="fa fa-lock m-r-5"></i> สมัครใช้บริการ</button></a>
                                <?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'btn btn-success float-right')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        <div id="recoverform">
            <div class="text-center">
                <span class="text-white">กรุณากรอกข้อมูลด้านล่างให้ครบ</span>
            </div>
            <div class="row m-t-20">
                <!-- Form -->
                <form class="col-12" action="index.html">
                    <!-- email -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-lg" placeholder="Email Address" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <!-- pwd -->
                    <div class="row m-t-20 p-t-20 border-top border-secondary">
                        <div class="col-12">
                            <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
                            <button class="btn btn-info float-right" type="button" name="action">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>