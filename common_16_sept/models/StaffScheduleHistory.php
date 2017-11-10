<?php

/**
 * This is the model class for table "staff_schedule_history".
 *
 * The followings are the available columns in table 'staff_schedule_history':
 * @property integer $id
 * @property integer $staff_id
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property integer $sun
 *
 * The followings are the available model relations:
 * @property Staff $staff
 */
class StaffScheduleHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'staff_schedule_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_id', 'required'),
			array('staff_id, mon, tue, wed, thu, fri, sat, sun', 'numerical', 'integerOnly'=>true),
            ['id','safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staff_id, mon, tue, wed, thu, fri, sat, sun', 'safe', 'on'=>'search'),
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
			'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staff_id' => Yii::t('default','Staff'),
			'mon' => Yii::t('default','Mon'),
			'tue' => Yii::t('default','Tue'),
			'wed' => Yii::t('default','Wed'),
			'thu' => Yii::t('default','Thu'),
			'fri' => Yii::t('default','Fri'),
			'sat' => Yii::t('default','Sat'),
			'sun' => Yii::t('default','Sun'),
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
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('mon',$this->mon);
		$criteria->compare('tue',$this->tue);
		$criteria->compare('wed',$this->wed);
		$criteria->compare('thu',$this->thu);
		$criteria->compare('fri',$this->fri);
		$criteria->compare('sat',$this->sat);
		$criteria->compare('sun',$this->sun);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffScheduleHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if(parent::beforeSave()){
            if(!$this->isNewRecord) $this->change_date = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }
}
