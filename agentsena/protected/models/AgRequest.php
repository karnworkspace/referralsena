<?php

/**
 * This is the model class for table "ag_request".
 *
 * The followings are the available columns in table 'ag_request':
 * @property integer $id
 * @property string $cus_id
 * @property string $agent_id
 * @property string $comment
 */
class AgRequest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ag_request';
	}

	public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->create_by = Yii::app()->user->id; //option by default
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
			array('cus_id, agent_id, comment', 'required'),
			array('cus_id', 'length', 'max'=>10),
			array('project_ref', 'length', 'max'=>11),
			array('agent_id,create_by', 'length', 'max'=>20),
			array('comment', 'length', 'max'=>450),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cus_id, agent_id, comment,create_by,project_ref', 'safe', 'on'=>'search'),
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
            'requests'=>array(self::HAS_MANY, 'AgRequest', 'id'),
            'projects'=>array(self::BELONGS_TO, 'Project', 'project_ref'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cus_id' => 'ชื่อ - สกุลลูกค้า',
			'agent_id' => 'เลขนายหน้า',
			'comment' => 'คำร้อง',
			'project_ref' =>'โครงการ',
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
		
		//$criteria->with = array('requests');
		//$criteria->with = array('customers');
		$criteria->with = array('projects');
		
		//$criteria->addCondition('requests.cus_id = customers.id');
		$criteria->addCondition('projects.project_sale = :project');
		$criteria->params[ ':project' ] = Yii::app()->user->project;

		$criteria->compare('id',$this->id);
		$criteria->compare('project_ref',$this->project_ref,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('cus_id',$this->cus_id,true);
		$criteria->compare('agent_id',$this->agent_id,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
