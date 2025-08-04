<?php

class AgCustomerController extends Controller
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
				'actions'=>array('admin','delete','AjaxAprove','duplicate','Salemail'),
			 	//'roles'=>array('admin'),
				'users'=>array('@'),
			 ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('login'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}





	public function actionduplicate($id)
	{
		//$id = (int)$_GET['id'];

		$this->render('duplicate',array(
			'model'=>$this->loadModel($id),
		));

	}

public function actionSalemail()   //edit 19-02-2025 เปิด comment ทั้ง function
	{ 
		//$id = (int)$_GET['id']; 
		$data_sale_mail = AgUser::model()->findAll(
				array(
				  'condition' => 'project LIKE :project AND active = :active',
				  'params'    => array(':active' => 0,':project' => '%"9"%')
				));

		foreach($data_sale_mail as $key_sale_mail => $value_sale_mail){
			echo $value_sale_mail->username."<br />";

		}

	}


	public function actionAjaxAprove_()
	{
		if(isset($_POST['prove_id']) and $_POST['prove_id'] != ""){
			$data_prove_id = (int)$_POST['prove_id'];
			$data_prove_st = $_POST['prove_st'];

			$model_prove = $this->loadModel($data_prove_id);

			if($model_prove){

				$model_prove->sena_approve = $data_prove_st;

				if($model_prove->save()){
					echo "1";
				}else{
					echo "0";
				}

			}else{
				echo "0";
			}

		}else{
			echo "0";
		}

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
		$model=new AgCustomer;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AgCustomer']))
		{
			$model->attributes=$_POST['AgCustomer'];
			/*หา cus ซ้ำ*/
			$model_ag_lead = AgLead::model()->findAll(
					array(
                      'condition' => "fname LIKE '%:search_fname%' AND lname LIKE '%:search_lname%' AND visitdate >= '2019-12-01'",
                      'params'    => array(':search_fname' => '%'.trim($model->fname).'%',':search_lname' => '%'.trim($model->lname).'%'),
                  	));
			$model_customer = AgCustomer::model()->findAll(
					array(
                      'condition' => "fname LIKE '%:search_fname%' AND lname LIKE '%:search_lname%' AND create_date >= '2019-12-01'",
                      'params'    => array(':search_fname' => '%'.trim($model->fname).'%',':search_lname' => '%'.trim($model->lname).'%'),
                  	));

				$array_duplicate_lead = array();
				if($model_ag_lead){
					foreach($model_ag_lead as $value_ag_lead=> $data_ag_lead){
						$array_duplicate_lead[] = array("tb"=>'lead',"lead_id"=>$data_ag_lead->id);
					}
				}

				$array_duplicate_cus = array();
				if($model_customer){
					foreach($model_customer as $value_customer=> $data_customer){
						$array_duplicate_cus[] = array("tb"=>'cus',"cus_id"=>$data_customer->id);
					}
				}


			$count_dup_lead = count($array_duplicate_lead);

			$count_dup_cus = count($array_duplicate_cus);

			$chk_dup = ($count_dup_lead + $count_dup_cus);

			//print_r(array_merge($array_duplicate_lead,$array_duplicate_cus));


			if($chk_dup > 0){
				//ซ้ำ

				$json_duplicate_lead = json_encode(array_merge($array_duplicate_lead,$array_duplicate_cus));


				//echo $json_duplicate_lead;

				//echo "<pre>";
				//print_r($model_ag_lead);
				//echo "</pre>";
				//exit();
				$model->is_duplicate = 'y';
				$model->duplicate_lead_id = $json_duplicate_lead;
			}else{
				$model->is_duplicate = 'n';
				$model->duplicate_lead_id = "";
				//echo "ไม่ซ้ำ";
				//exit(print_r($model_ag_lead));
			}

			/*end หา cus ซ้ำ*/
			if($model->save())
				// $this->redirect(array('view','id'=>$model->id));

				/*send mail*/
					Yii::import('application.extensions.phpmailer.JPhpMailer');
					$mail = new JPhpMailer;
					$mail->IsSMTP();
					$mail->Host = 'smtp.sena.co.th';
					$mail->Port = '587';
					$mail->SMTPSecure = 'TLS';
					$mail->SMTPAuth = true;
					$mail->CharSet = 'utf-8';
					$mail->Username = 'pridesena@sena.co.th';
					$mail->Password = 'SenaN3xT';

					$mail->SetFrom('psd.happyrefer@gmail.com', 'SENA HAPPY REFER');
					$mail->addBCC('webdev@sena.co.th');
					$mail->Subject = 'มีนายหน้าจัดส่งรายชื่อลูกค้าเข้ามาใหม่';
					$mail->MsgHTML("
									<b>เรียนเจ้าหน้าที่</b>
									<br /><br />
									<strong>มีนายหน้าจัดส่งรายชื่อลูกค้าเข้ามาใหม่<strong>
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
										<td>".JobFunction::GetCusName($model->id)."</td>
									  </tr>
									  <tr>
										<th scope=\"row\">โครงการที่สนใจ : </th>
										<td>".JobFunction::GetProjectName($model->project)."</td>

									  </tr>
									  <tr>
									  <th scope=\"row\">เบอร์โทรศัพท์ : </th>
										<td>".JobFunction::GetProjectName($model->phone)."</td>
										</tr>
									</table>
									<strong>ตรวจสอบข้อมูล<strong><br />
									<strong><a href=\"https://sena.co.th/agentsena/senacontrol/index.php/site/login\">ตรวจสอบข้อมูลที่นี่</a><strong>
									");
									$data_sale_mail = AgUser::model()->findAll(
											array(
											  'condition' => 'project LIKE :project AND active = :active',
											  'params'    => array(':active' => 0,':project' => '%"'.$model->project.'"%')
											));

						foreach($data_sale_mail as $key_sale_mail => $value_sale_mail){

							$mail->AddAddress($value_sale_mail->username);
							$mail->AddAddress('info@sena.co.th', 'สุรชัย พัฒเท');
							$mail->AddAddress('surachaip.sena@gmail.com', 'สุรชัย พัฒเท gmail');
							$mail->AddAddress('webdev@sena.co.th', 'WEB DEV');
							//$mail->AddAddress('psd.happyrefer@gmail.com', 'psd.happyrefer@gmail.com');

							// list mail Acute
							/*$mail->AddAddress('thitapas@acuterealty.com', 'thitapas@acuterealty.com');
							$mail->AddAddress('rujirat@acuterealty.com', 'rujirat@acuterealty.com');
							$mail->AddAddress('cs_property@acuterealty.com', 'cs_property@acuterealty.com');
							$mail->AddAddress('cs@acuterealty.com', 'cs@acuterealty.com');
							$mail->AddAddress('sale.co2@acuterealty.com', 'sale.co2@acuterealty.com');
							$mail->AddAddress('suparporn@acuterealty.com', 'suparporn@acuterealty.com');
							$mail->AddAddress('phutthiphong@acuterealty.com', 'phutthiphong@acuterealty.com');
							$mail->AddAddress('narulmon@acuterealty.com', 'narulmon@acuterealty.com');*/
												/*end send mail*/
									}
									$mail->Send();
						
						/*if($mail->Send()){

							$send_mail_st = "y";
 			

						}else{
							$send_mail_st = "n";
							return "Mailer Error: " . $mail->ErrorInfo;
						}  */



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

		if(isset($_POST['AgCustomer']))
		{
			$model->attributes=$_POST['AgCustomer'];
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

		$model = AgCustomer::model()->findAll(
					array(
                      'condition' => 'create_by = :createby',
                      'params'    => array(':createby' => Yii::app()->user->getId()),
                  	));

		$this->render('index',array(
			'model'=>$model,
		));





		//$dataProvider=new CActiveDataProvider('AgCustomer', array(

		//	    'criteria'=>array(
			        	// 'condition'=>'create_by='.Yii::app()->user->getId().' AND sena_approve =1'
								//'condition'=>'create_by='.Yii::app()->user->getId().''
			    //),
		//));

		// $dataProvider2=new CActiveDataProvider('AgCustomer', array(
		//
		// 	    'criteria'=>array(
		// 	        	'condition'=>'create_by='.Yii::app()->user->getId().' AND sena_approve =0'
		// 	    ),
		// ));

		//$this->render('index',array(
		//	'dataProvider'=>$dataProvider,
			// 'dataProvider2'=>$dataProvider2,

		//));
	}

	public function actionAll(){

			$datalist = AgCustomer::model()->cus_id_order()->findAll(array(
	                      'condition' => 'YEAR(create_date) = YEAR(CURDATE()) OR YEAR(create_date) = YEAR(CURDATE())-1',
						  ));

			$this->render('_Gview',array('listcustomer'=>$datalist));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin__()
	{
		$model=new AgCustomer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AgCustomer']))
			$model->attributes=$_GET['AgCustomer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AgCustomer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AgCustomer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AgCustomer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ag-customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
