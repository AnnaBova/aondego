<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "staff_schedule".
 *
 * The followings are the available columns in table 'staff_schedule':
 * @property integer $id
 * @property string $work_date
 * @property integer $status
 * @property integer $schedule_days_template_id
 * @property integer $staff_id
 *
 * The followings are the available model relations:
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 * @property Staff $staff
 * @property TimeRange[] $timeRanges
 */
class StaffSchedule extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'staff_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['work_date', 'reason'], 'required'],
			[['status', 'schedule_days_template_id', 'staff_id'],'integer'],
            ['reason','string', 'max'=>255],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['id, work_date, status, schedule_days_template_id, staff_id', 'safe', 'on'=>'search'),
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
			'scheduleDaysTemplate' => array(self::BELONGS_TO, 'ScheduleDaysTemplate', 'schedule_days_template_id'),
			'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
			//'timeRanges' => array(self::MANY_MANY, 'TimeRange', 'staff_schedule_has_time_range(staff_schedule_id, time_range_id)'),
		);
	}
        
        public function getStaff(){
            return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
        }
        
        public function getScheduleDaysTemplate(){
            return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'schedule_days_template_id']);
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'work_date' => Yii::t('app','Work Date'),
			'status' => Yii::t('app','Status'),
			'schedule_days_template_id' => Yii::t('app','Schedule Days Template'),
			'staff_id' => Yii::t('app','Staff'),
            'reason' => Yii::t('app','Reason')
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
		$criteria->compare('schedule_days_template_id',$this->schedule_days_template_id);
		$criteria->compare('staff_id',$this->staff_id);
        $criteria->with = 'staff';
        $criteria->together = true;

        $criteria->addCondition('staff.merchant_id='.Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffSchedule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave($insert, $changedAttributes){

        //$condition = new CDbCriteria();
        $condition = 'staff_id = '.$this->staff_id.' AND order_time>= "'.$this->work_date.' 00:00:00'.'" AND order_time<="'.$this->work_date . ' 23:59:59'.'"';
        
        
        $orders = SingleOrder::find()->where($condition)->all();
        
       
        foreach($orders as $order){
            
            $setFree = true;
            if($this->scheduleDaysTemplate){
                
                foreach($this->scheduleDaysTemplate->timeRanges as $val){
                    
                    if(($order->order_time>=$this->work_date.' '.$val->time_from.':00')&&
                            ($order->order_time<$this->work_date.' '.$val->time_to.':00')&&
                            (date('Y-m-d H:i:s',strtotime("+{$order->getOrderTimeLength()}",strtotime($order->order_time)))>$this->work_date.' '.$val->time_from.':00')&&
                            (date('Y-m-d H:i:s',strtotime("+{$order->getOrderTimeLength()}",strtotime($order->order_time)))<=$this->work_date.' '.$val->time_to.':00')){
                        $setFree = false;
                        
                        break;
                    }
                }
                
                exit; 
            }
            if($setFree){
                $order->staff_id = null;
                $order->save(false);
            }
        }
       parent::afterSave($insert, $changedAttributes);
    }
}
