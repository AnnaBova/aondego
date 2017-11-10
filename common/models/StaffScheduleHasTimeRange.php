<?php
namespace common\models;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "staff_schedule_has_time_range".
 *
 * The followings are the available columns in table 'staff_schedule_has_time_range':
 * @property integer $staff_schedule_id
 * @property integer $time_range_id
 * @property integer $status
 */
class StaffScheduleHasTimeRange extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'staff_schedule_has_time_range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['staff_schedule_id', 'time_range_id'], 'required'],
			[['staff_schedule_id', 'time_range_id', 'status'],'integer'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('staff_schedule_id, time_range_id, status', 'safe', 'on'=>'search'),
		];
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
			'staff_schedule_id' => Yii::t('basicfield','Staff Schedule'),
			'time_range_id' => Yii::t('basicfield','Time Range'),
			'status' => Yii::t('basicfield','Status'),
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

		$criteria->compare('staff_schedule_id',$this->staff_schedule_id);
		$criteria->compare('time_range_id',$this->time_range_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffScheduleHasTimeRange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
