<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "staff_merchant_history".
 *
 * The followings are the available columns in table 'staff_merchant_history':
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property integer $sun
 * @property string $change_date
 *
 * The followings are the available model relations:
 * @property Merchant $merchant
 * @property ScheduleDaysTemplate $mon0
 * @property ScheduleDaysTemplate $tue0
 * @property ScheduleDaysTemplate $wed0
 * @property ScheduleDaysTemplate $thu0
 * @property ScheduleDaysTemplate $fri0
 * @property ScheduleDaysTemplate $sat0
 * @property ScheduleDaysTemplate $sun0
 */
class MerchantScheduleHistory extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'merchant_schedule_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['merchant_id', 'required'],
			[['merchant_id', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],'integer'],
			['change_date', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, merchant_id, mon, tue, wed, thu, fri, sat, sun, change_date', 'safe', 'on'=>'search'),
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
			'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
			'mon0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'mon'),
			'tue0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'tue'),
			'wed0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'wed'),
			'thu0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'thu'),
			'fri0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'fri'),
			'sat0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'sat'),
			'sun0' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'sun'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'merchant_id' => Yii::t('default','Merchant'),
			'mon' => Yii::t('default','Mon'),
			'tue' => Yii::t('default','Tue'),
			'wed' => Yii::t('default','Wed'),
			'thu' => Yii::t('default','Thu'),
			'fri' => Yii::t('default','Fri'),
			'sat' => Yii::t('default','Sat'),
			'sun' => Yii::t('default','Sun'),
			'change_date' => Yii::t('default','Change Date'),
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
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('mon',$this->mon);
		$criteria->compare('tue',$this->tue);
		$criteria->compare('wed',$this->wed);
		$criteria->compare('thu',$this->thu);
		$criteria->compare('fri',$this->fri);
		$criteria->compare('sat',$this->sat);
		$criteria->compare('sun',$this->sun);
		$criteria->compare('change_date',$this->change_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MerchantScheduleHistory the static model class
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
