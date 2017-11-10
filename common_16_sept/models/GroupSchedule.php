<?php

/**
 * This is the model class for table "group_schedule".
 *
 * The followings are the available columns in table 'group_schedule':
 * @property integer $id
 * @property string $work_date
 * @property integer $status
 * @property integer $group_id
 * @property string $reason
 * @property integer $schedule_days_template_id
 *
 * The followings are the available model relations:
 * @property CategoryHasMerchant $group
 */
class GroupSchedule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_date', 'required'),
			array('status, group_id, schedule_days_template_id', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>520),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, work_date, status, group_id, reason, schedule_days_template_id', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'CategoryHasMerchant', 'group_id'),
            'groupScheduleDaysTemplate' => array(self::BELONGS_TO, 'GroupScheduleDaysTemplate', 'schedule_days_template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'work_date' => Yii::t('default','Work Date'),
			'status' => Yii::t('default','Status'),
			'group_id' => Yii::t('default','Group'),
			'reason' => Yii::t('default','Reason'),
			'schedule_days_template_id' => Yii::t('default','Schedule Days Template'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('work_date',$this->work_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('schedule_days_template_id',$this->schedule_days_template_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupSchedule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getModel(){
        return $this;
    }
}
