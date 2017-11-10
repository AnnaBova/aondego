<?php
namespace common\models;
use yii\db\ActiveRecord;
use common\models\Merchant;
use Yii;

use common\models\ScheduleDaysTemplate;

/**
 * This is the model class for table "merchant_schedule".
 *
 * The followings are the available columns in table 'merchant_schedule':
 * @property integer $id
 * @property string $work_date
 * @property integer $status
 * @property integer $merchant_id
 * @property string $reason
 * @property integer $schedule_days_template_id
 *
 * The followings are the available model relations:
 * @property Merchant $merchant
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 */
class MerchantSchedule extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'merchant_schedule';
	}

    public function getModel()
    {
        return $this;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['work_date', 'reason', 'work_date_to'], 'required'],
			[['status', 'merchant_id', 'schedule_days_template_id'],'integer'],
			['reason', 'string', 'max'=>520],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, work_date, status, merchant_id, reason, schedule_days_template_id', 'safe', 'on'=>'search'),
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
			'work_date' => Yii::t('basicfield','Work Date From'),
			'work_date_to' => Yii::t('basicfield','Work Date To'),
			'status' => Yii::t('basicfield','Status'),
			'merchant_id' => Yii::t('basicfield','Merchant'),
			'reason' => Yii::t('basicfield','Reason'),
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
	
        
        public function getScheduleDaysTemplate(){
            return  $this->hasOne(ScheduleDaysTemplate::className(),['id'=> 'schedule_days_template_id']);
        }
        
        public function beforeSave($insert)
        {

            if(!empty($this->work_date)){

               $this->work_date = date('Y-m-d', strtotime($this->work_date)); 
	       
            }
	    $this->work_date_to = date('Y-m-d', strtotime($this->work_date_to));
            return parent::beforeSave($insert);
        }

        public function afterFind()
        {

            if(!empty($this->work_date)) $this->work_date = date('d-m-Y', strtotime($this->work_date));
	    if(!empty($this->work_date_to)) $this->work_date_to = date('d-m-Y', strtotime($this->work_date_to));


            parent::afterFind();
        }
}
