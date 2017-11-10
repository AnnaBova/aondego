<?php

/**
 * This is the model class for table "group_time_range".
 *
 * The followings are the available columns in table 'group_time_range':
 * @property integer $id
 * @property string $time_start
 * @property integer $group_schedule_days_template_id
 *
 * The followings are the available model relations:
 * @property GroupScheduleDaysTemplate $groupScheduleDaysTemplate
 */
class GroupTimeRange extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_time_range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time_start', 'required'),
			array('group_schedule_days_template_id', 'numerical', 'integerOnly'=>true),
			array('time_start', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, time_start, group_schedule_days_template_id', 'safe', 'on'=>'search'),
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
			'groupScheduleDaysTemplate' => array(self::BELONGS_TO, 'GroupScheduleDaysTemplate', 'group_schedule_days_template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time_start' => Yii::t('default','Time Start'),
			'group_schedule_days_template_id' => Yii::t('default','Group Schedule Days Template'),
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
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('group_schedule_days_template_id',$this->group_schedule_days_template_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupTimeRange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
