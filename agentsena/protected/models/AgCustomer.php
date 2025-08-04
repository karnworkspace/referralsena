<?php

/**
 * This is the model class for table "ag_customer".
 *
 * The followings are the available columns in table 'ag_customer':
 * @property integer $id
 * @property string $agent_id
 * @property string $fname
 * @property string $lname
 * @property string $project
 * @property string $budget
 * @property string $phone
 * @property string $idcard
 */
class AgCustomer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ag_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agent_id, fname, lname, project, budget', 'required'),
			array('update_by, create_by, id, open_request', 'numerical', 'integerOnly'=>true),
			array('agent_id', 'length', 'max'=>20),
			array('is_duplicate, sena_approve, open_request', 'length', 'max'=>1),
			array('fname, lname', 'length', 'max'=>50),
			array('project, budget', 'length', 'max'=>150),
			array('duplicate_lead_id', 'length', 'max'=>500),
			array('phone, idcard', 'length', 'max'=>15),
			array('agent_id+fname+lname+project', 'application.extensions.uniqueMultiColumnValidator'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, agent_id, fname, lname, project, budget, phone, idcard,comment,is_duplicate,create_date,active,create_by,user_ip,update_date,update_by,duplicate_lead_id,sena_approve,open_request', 'safe', 'on'=>'search'),
		);
	}

	public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->create_date=new CDbExpression('NOW()');
			$this->active = "y";
			$this->sena_approve = "0";
            $this->create_by = Yii::app()->user->id; //option by default
			$this->user_ip = Yii::app()->request->userHostAddress;
        }else{
        	$this->update_date=new CDbExpression('NOW()');
            $this->update_by = Yii::app()->user->id;
        }
        return parent::beforeSave();

    }

	public function defaultScope()
	{
	 return array(
				'condition'=>"active='y'",
			);
	}
	public function scopes() {
		return array(
			'cus_id_order' => array('order' => 'id DESC'),
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        return array(
            'customers'=>array(self::HAS_MANY, 'AgCustomer', 'id'),
            'projects'=>array(self::BELONGS_TO, 'Project', 'project'),
        );
    }	
	
	public function getFullName() {

        return $this->fname.' '.$this->lname;

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'agent_id' => 'เลขนายหน้า',
			'fname' => 'ชื่อ',
			'lname' => 'นามสกุล',
			'project' => 'โครงการ',
			'budget' => 'งบประมาณ',
			'phone' => 'เบอร์โทร',
			'idcard' => 'รหัสประชาชน',
			'is_duplicate' => 'เช็คซ้ำ',
			'duplicate_lead_id' => 'ซ้ำกับรายชื่อ',
			'comment' => 'หมายเหตุ',
			'create_date' => 'วันที่ลงข้อมูล',
			'open_request' => 'สถานะยื่นคำร้อง',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('projects');
		$criteria->addCondition('projects.project_sale = :project');
		$criteria->params[ ':project' ] = Yii::app()->user->project;
		
		//$criteria->compare('projects.project_sale' , Yii::app()->user->project,true);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('agent_id',$this->agent_id,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('is_duplicate',$this->is_duplicate,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('project',$this->project,true);
		$criteria->compare('budget',$this->budget,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('open_request',$this->open_request,true);
		$criteria->order = "create_date DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgCustomer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
