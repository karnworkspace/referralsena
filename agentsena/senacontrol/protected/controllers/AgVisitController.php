<?php

class AgVisitController extends Controller
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','Sendmail','AjaxAprove'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','list'),
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
		
		$array_project_id = json_decode(Yii::app()->user->project);
		$project_id = array();
		if($array_project_id){
			foreach($array_project_id as $value_project_id => $data_project_id){
				 array_push($project_id,$data_project_id->id);
			}
		
		}
		
		$model_visit = $this->loadModel($id);
		if (in_array($model_visit->project, $project_id)){
		$this->render('view',array(
			'model'=>$model_visit,
		));
		
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
	}


	public function actionAjaxAprove()
	{
		if(isset($_POST['prove_id']) and $_POST['prove_id'] != ""){
			$data_prove_id = (int)$_POST['prove_id'];
			$data_prove_st = $_POST['prove_st'];
			
			$model_prove = $this->loadModel($data_prove_id);
			
			if($model_prove){
				
				$model_prove->status = $data_prove_st;
				
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate_()
	{
		$model=new AgVisit;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgVisit']))
		{
			$model->attributes=$_POST['AgVisit'];
			if($model->save())
			
			/*send mail*/
				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$mail->IsSMTP();
				$mail->Host = 'smtp.sena.co.th';
				$mail->Port = '587';
				$mail->SMTPSecure = 'TLS';
				$mail->SMTPAuth = true;
				$mail->CharSet= "utf-8";
				$mail->Username = 'pridesena@sena.co.th';
				$mail->Password = 'SenaN3xT';
				//$mail->SetFrom('info-coagent@sena.co.th', 'SENA CO-AGENT');
				$mail->SetFrom('surachaip@sena.co.th', 'SENA HAPPY REFER');
				
				$mail->addBCC('psd.happyrefer@gmail.com,webdev@sena.co.th', 'SENA HAPPY REFER');
				$mail->Subject = 'นัดหมายเยี่ยมชมโครงการจากนายหน้า';
				$mail->MsgHTML("
								<b>เรียนเจ้าหน้าที่</b>
								<br />
								<b>นัดหมายเยี่ยมชมโครงการ : ".JobFunction::GetProjectName($model->project)." วันที่ ".DateThai::date_thai_convert($model->visit_date,false)."</b>
								<br />
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
									<th scope=\"row\">โครงการที่จะเยี่ยมชม : </th>
									<td>".JobFunction::GetProjectName($model->project)."</td>
								  </tr>
								  <tr>
									<th scope=\"row\">วันนัดหมาย : </th>
									<td>".DateThai::date_thai_convert($model->visit_date,false)."</td>
								  </tr>
								  
								</table>
								");
				$mail->AddAddress(JobFunction::GetStaffMail($model->project),'Agent Staff');
							
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
	public function actionUpdate_($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgVisit']))
		{
			$model->attributes=$_POST['AgVisit'];
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
	public function actionIndex_()
	{
		// $dataProvider=new CActiveDataProvider('AgVisit');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
		$model = AgVisit::model()->findAll(
					array(
                      'condition' => 'create_by = :createby',
                      'params'    => array(':createby' => Yii::app()->user->getId())
                  	));

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionSendmail()
	{
							Yii::import('application.extensions.phpmailer.JPhpMailer');
							$mail = new JPhpMailer;
							$mail->IsSMTP();
				$mail->Host = 'smtp.sena.co.th';
				$mail->Port = '587';
				$mail->SMTPSecure = 'TLS';
				$mail->SMTPAuth = true;
				$mail->CharSet= "utf-8";
				$mail->Username = 'pridesena@sena.co.th';
				$mail->Password = 'SenaN3xT';
				//$mail->SetFrom('info-coagent@sena.co.th', 'SENA CO-AGENT');
				$mail->SetFrom('surachaip@sena.co.th', 'SENA HAPPY REFER');
				
				$mail->addBCC('psd.happyrefer@gmail.com,webdev@sena.co.th', 'SENA HAPPY REFER');
							$mail->Subject = 'นัดหมายเยี่ยมชมโครงการจากนายหน้า';
							$mail->MsgHTML("
											<b>เรียนเจ้าหน้าที่</b>
											<br />
											<b>นัดหมายเยี่ยมชมโครงการ : ".JobFunction::GetProjectName(5)." วันที่ ".DateThai::date_thai_convert("2020-05-24",false)."</b>
											<br />
											<b>รายละเอียด</b>
											
											<table width=\"100%\" border=\"0\">
											  <tr>
												<th scope=\"col\">เลขนายหน้า : </th>
												<td>3102400475206</td>
											  </tr>
											  <tr>
												<th scope=\"col\">ชื่อ สกุลนายหน้า : </th>
												<td>".Yii::app()->user->name." ".Yii::app()->user->lname."</td>
											  </tr>
											  <tr>
												<th scope=\"row\">ชื่อ สกุลลูกค้า : </th>
												<td>นฤดม สละอุบล</td>
											  </tr>
											  <tr>
												<th scope=\"row\">โครงการที่จะเยี่ยมชม : </th>
												<td>".JobFunction::GetProjectName(9)."</td>
											  </tr>
											  <tr>
												<th scope=\"row\">วันนัดหมาย : </th>
												<td>".DateThai::date_thai_convert("2020-05-24",false)." ".JobFunction::GetStaffMail(5)."</td>
											  </tr>
											  
											</table>
											");
							$mail->AddAddress('arthapon.sena@gmail.com','Agent Staff');
										
							$mail->Send();
		}

	/**
	 * Manages all models.
	 */
	public function actionList()
	{
		$model=new AgVisit('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AgVisit']))
			$model->attributes=$_GET['AgVisit'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AgVisit the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AgVisit::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AgVisit $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ag-visit-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
