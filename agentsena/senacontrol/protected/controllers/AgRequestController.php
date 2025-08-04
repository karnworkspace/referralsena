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
		
		$array_project_id = json_decode(Yii::app()->user->project);
		$project_id = array();
		if($array_project_id){
			foreach($array_project_id as $value_project_id => $data_project_id){
				 array_push($project_id,$data_project_id->id);
			}
		
		}
		
		$model_request = $this->loadModel($id);
		if (in_array($model_request->project_ref, $project_id)){
		$this->render('view',array(
			'model'=>$model_request,
		));
		
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate_()
	{
		$model=new AgRequest;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgRequest']))
		{
			$model->attributes=$_POST['AgRequest'];
			/*project_ref*/
			$model_customer = AgCustomer::model()->findByPk($model->cus_id);
			if($model_customer){
				$model->project_ref = $model_customer->project;
			}else{
				$model->project_ref = 0;
			}
			/*end project_ref*/
			
			if($model->save())
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
	public function actionIndex_()
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
	public function actionAdmin()
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
