<?php

class AgRequestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AgRequest;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AgRequest']))
		{
			$model->attributes=$_POST['AgRequest'];
			/*project_ref*/
			$model_customer = AgCustomer::model()->findByPk($model->cus_id);

			if($model_customer){
				$model->project_ref = $model_customer->project;
				if($model_customer->sena_approve != 1){
					$model_customer->sena_approve = 0;
					$model_customer->save();
				}
			}else{
				$model->project_ref = 0;
			}
			/*end project_ref*/

			if($model->save())
						/*send mail*/
				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$mail->IsSMTP();
				$mail->Host = 'smtp.sena.co.th';
				$mail->Port = '587';
				$mail->SMTPSecure = 'TLS';
				$mail->SMTPAuth = true;
				$mail->CharSet= 'utf-8';
				$mail->Username = 'pridesena@sena.co.th';
				$mail->Password = 'SenaN3xT';
				$mail->SetFrom('psd.happyrefer@gmail.com', 'SENA HAPPY REFER');
				$mail->Subject = 'รายการยื่นคำร้องจากนายหน้า';
				$mail->MsgHTML("
								<b>เรียนเจ้าหน้าที่</b>
								<br /><br />
								<strong>รายการยื่นคำร้องจากนายหน้า<strong>
								<br /><br />
								<b>รายละเอียด</b>

								<table width=\"100%\" border=\"0\">
								  <tr>
									<th scope=\"col\">เลขนายหน้า : </th>
									<td>".Yii::app()->user->code_ref."</td>
								  </tr>
								  <tr>
									<th scope=\"col\">ชื่อ สกุลนายหน้า : </th>
									<td>".Yii::app()->user->name." ".Yii::app()->user->lname."</td>
								  </tr>
								  <tr>
									<th scope=\"row\">ชื่อ สกุลลูกค้า : </th>
									<td>".JobFunction::GetCusName($model->cus_id)."</td>
								  </tr>
								  <tr>
									<th scope=\"row\">โครงการที่สนใจ : </th>
									<td>".JobFunction::GetProjectName($model->project_ref)."</td>
								  </tr>
								  <tr>
									<th scope=\"row\">คำร้อง : </th>
									<td>".$model->comment."</td>
								  </tr>

								</table>
								<strong>ตรวจสอบข้อมูล<strong><br />
								<strong><a href=\"https://sena.co.th/agentsena/senacontrol/index.php/site/login\">ตรวจสอบข้อมูลที่นี่</a><strong>
								");
								$data_sale_mail = AgUser::model()->findAll(
										array(
										  'condition' => 'project LIKE :project AND active = :active',
										  'params'    => array(':active' => 0,':project' => '%"'.$model->project_ref.'"%')
										));

						foreach($data_sale_mail as $key_sale_mail => $value_sale_mail){

								$mail->AddAddress($value_sale_mail->username);										
								$mail->AddAddress('info@sena.co.th', 'สุรชัย พัฒเท');
								$mail->AddAddress('surachaip.sena@gmail.com', 'สุรชัย พัฒเท gmail');
							    $mail->AddAddress('webdev@sena.co.th', 'WEB DEV');
								//$mail->AddAddress('thitapas.acr@gmail.com', 'SENA Co-Agent');
								// list mail Acute
								/*$mail->AddAddress('thitapas@acuterealty.com', 'thitapas@acuterealty.com');
								$mail->AddAddress('rujirat@acuterealty.com', 'rujirat@acuterealty.com');
								$mail->AddAddress('cs_property@acuterealty.com', 'cs_property@acuterealty.com');
								$mail->AddAddress('cs@acuterealty.com', 'cs@acuterealty.com');
								$mail->AddAddress('sale.co2@acuterealty.com', 'sale.co2@acuterealty.com');
								$mail->AddAddress('suparporn@acuterealty.com', 'suparporn@acuterealty.com');
								$mail->AddAddress('phutthiphong@acuterealty.com', 'phutthiphong@acuterealty.com');
								$mail->AddAddress('narulmon@acuterealty.com', 'narulmon@acuterealty.com');*/

								}
								$mail->Send();
								/*end send mail*/



				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgRequest']))
		{
			$model->attributes=$_POST['AgRequest'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model = AgRequest::model()->findAll(
					array(
                      'condition' => 'create_by = :createby',
                      'params'    => array(':createby' => Yii::app()->user->getId())
                  	));

		$this->render('index',array(
			'model'=>$model,
		));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin__()
	{
		$model=new AgRequest('search');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AgRequest']))
			$model->attributes=$_GET['AgRequest'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AgRequest the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AgRequest::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AgRequest $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ag-request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
