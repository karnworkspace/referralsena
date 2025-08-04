<?php

/**
 * This is the model class for table "ag_visit".
 *
 * The followings are the available columns in table 'ag_visit':
 * @property integer $id
 * @property string $agent_id
 * @property string $cus_id
 * @property string $project
 * @property string $visit_date
 * @property string $create_date
 * @property string $create_by
 * @property string $status
 * @property string $staff_id
 * @property string $status_date
 */
class AgVisit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ag_visit';
	}
	public function beforeSave()
		{
		if($this->isNewRecord){
			$this->status = "0";
			$this->create_by = Yii::app()->user->id;
		}else{
			$this->status_date=new CDbExpression('NOW()');
            $this->staff_id = Yii::app()->user->id;

			
		}
		return parent::beforeSave();

		}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agent_id, cus_id, project, visit_date', 'required'),
			array('agent_id, cus_id, project, staff_id, status_date', 'length', 'max'=>20),
			array('visit_date', 'length', 'max'=>30),
			array('create_by', 'length', 'max'=>15),
			array('status', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, agent_id, cus_id, project, visit_date, create_date, create_by, status, staff_id, status_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'agent_id' => 'เลขนายหน้า',
			'cus_id' => 'ชื่อ-สกุลลูกค้า',
			'project' => 'โครงการที่นัดหมาย',
			'visit_date' => 'วัน-เวลาที่นัดหมาย',
			'create_date' => 'วันที่สร้าง',
			'create_by' => 'สร้างโดย',
			'status' => 'สถานะลูกค้า',
			'staff_id' => 'เจ้าหน้าที่',
			'status_date' => 'วันที่อัพเดท',
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

		$array_project_id = json_decode(Yii::app()->user->project);
		$project_id = array();
		if($array_project_id){
			foreach($array_project_id as $value_project_id => $data_project_id){
				 array_push($project_id,$data_project_id->id);
			}
		
		}
		
		$criteria->addInCondition("project", $project_id);

		$criteria->compare('id',$this->id);
		$criteria->compare('agent_id',$this->agent_id,true);
		$criteria->compare('cus_id',$this->cus_id,true);
		$criteria->compare('project',$this->project,true);
		$criteria->compare('visit_date',$this->visit_date,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('status_date',$this->status_date,true);
		$criteria->order = "create_date DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgVisit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
