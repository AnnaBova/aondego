<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "time_range".
 *
 * The followings are the available columns in table 'time_range':
 * @property integer $id
 * @property string $time_from
 * @property string $time_to
 * @property string $additional_time
 * @property integer $schedule_days_template_id
 *
 * The followings are the available model relations:
 * @property StaffSchedule[] $staffSchedules
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 */
class TimeRange extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'time_range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['time_from', 'time_to'], 'required'],
			[['schedule_days_template_id'],'integer'],
			[['time_from', 'time_to', 'additional_time'], 'string', 'max'=>45],
                        ['time_from','compare','compareAttribute'=>'time_to','operator'=>'<' ],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, time_from, time_to, additional_time, schedule_days_template_id', 'safe', 'on'=>'search'),
		];
	}



    public function beforeValidate(){

        if(strlen($this->time_from)==4) $this->time_from = '0'.$this->time_from;
        return parent::beforeValidate();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'scheduleDaysTemplate' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'schedule_days_template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time_from' => Yii::t('basicfield','Time From'),
			'time_to' => Yii::t('basicfield','Time To'),
			'additional_time' => Yii::t('basicfield','Additional Time'),
			'schedule_days_template_id' => Yii::t('basicfield','Schedule Days Template'),
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
		$criteria->compare('time_from',$this->time_from,true);
		$criteria->compare('time_to',$this->time_to,true);
		$criteria->compare('additional_time',$this->additional_time,true);
		$criteria->compare('schedule_days_template_id',$this->schedule_days_template_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TimeRange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
