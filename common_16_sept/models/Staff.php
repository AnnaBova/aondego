<?php

/**
 * This is the model class for table "staff".
 *
 * The followings are the available columns in table 'staff':
 * @property integer $id
 * @property string $name
 * @property integer $category_has_merchant_category_id
 * @property integer $category_has_merchant_merchant_id
 *
 * The followings are the available model relations:
 * @property CategoryHasMerchant $categoryHasMerchantCategory
 * @property CategoryHasMerchant $categoryHasMerchantMerchant
 * @property StaffSchedule[] $staffSchedules
 * @property Addon[] $addons
 */
class Staff extends CActiveRecord
{

    public function primaryKey(){
        return 'id';
    }
    const UPLOAD_DIR = 'staff';
    public $image;
    public $category_list = [];
    public $addon_list = [];

    public $category_id;

    private $shedules = [];

    public $oneMany = [];
    public $oneMany2 = [];

    public  $staffShedAttr;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, merchant_id', 'required'),
			array('merchant_id, is_active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
            array('image', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
            ['category_id, category_list, addon_list, oneMany, oneMany2','safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,category_id', 'safe', 'on'=>'search'),
		);
	}

    public function getAllCatForEcho()
    {
        $result = '';
        foreach($this->categories as $val){
            $result.=$val->title.' ';
        }
        return $result;
    }

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => 'ImageBehavior',
                'imagePath' => self::UPLOAD_DIR,
            ),
            'CAdvancedArBehavior' => array(
                'class' => 'site.common.extensions.CAdvancedArBehavior'),
            'oneManyBehavior' => array(
                'class' => 'OneManyBehavior',
                'fields'=> [['attr'=>'schedule_days_template_id','label'=>'Schedule Days Template','type'=>'dropDown','data'=>CHtml::listData(ScheduleDaysTemplate::model()->findAll('merchant_id = '.Yii::app()->user->id),'id','title')],
                    ['attr'=>'reason','label'=>'Reason','type'=>'textInput'],
                    ['attr'=>'work_date','label'=>'Date','type'=>'date'],
                    //['attr'=>'work_time','label'=>'Time','type'=>'time']
                    ],
                'relation' => 'futureStaffSchedules',
                'relationModel' => 'StaffSchedule',
                'parent_column_name' => 'staff_id'
            ),

            'vacationBehavior' => array(
                'class' => 'OneManyBehavior',
                'oneManyField' => 'oneMany2',
                'fields'=> [
                    ['attr'=>'remark','label'=>'Reason','type'=>'textInput'],['attr'=>'start_date','label'=>'Start Date','type'=>'date'],['attr'=>'end_date','label'=>'End Date','type'=>'date']],
                'relation' => 'futureStaffVacations',
                'relationModel' => 'StaffVacation',
                'parent_column_name' => 'staff_id'
            ),
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
            'staff_has_category' => [self::HAS_MANY,'StaffHasCategory', 'staff_id'],
            'groupCat' => [self::HAS_MANY,'CategoryHasMerchant', 'staff_id'],
            'addon_has_staff' => [self::HAS_MANY,'AddonHasStaff', 'staff_id'],
			'categories' => array(self::MANY_MANY, 'CategoryHasMerchant', 'staff_has_category(staff_id, category_id)'),
            'addons' => array(self::MANY_MANY, 'Addon', 'addon_has_staff(staff_id, addon_id)'),
			'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
			'staffSchedules' => array(self::HAS_MANY, 'StaffSchedule', 'staff_id'),
            'futureStaffSchedules' => array(self::HAS_MANY, 'StaffSchedule', 'staff_id','condition'=>'work_date>="'.date('Y-m-d').'"'),
            'futureFreeStaffSchedules' => array(self::HAS_MANY, 'StaffSchedule', 'staff_id','condition'=>'work_date>="'.date('Y-m-d').'" AND schedule_days_template_id is NULL'),
            'staffVacations' => array(self::HAS_MANY, 'StaffVacation', 'staff_id'),
            'futureStaffVacations' => array(self::HAS_MANY, 'StaffVacation', 'staff_id','condition'=>'end_date>="'.date('Y-m-d').'"'),
            'orders' => array(self::HAS_MANY, 'SingleOrder', 'staff_id'),
            'futureOrders' => array(self::HAS_MANY, 'SingleOrder', 'staff_id', 'condition'=>'order_time>="' . date('Y-m-d') . ' 00:00:00"'),
            'lastSchedule' => array(self::HAS_ONE, 'StaffScheduleHistory', 'staff_id','order'=>'id DESC'),
            'schedule' => array(self::HAS_MANY, 'StaffScheduleHistory', 'staff_id'),
		);
	}

    private  function getDayByDayId($id){
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
            return $days[$id-1];
    }



    public function getIsTimeInSchedule($day,$time)
    {
        if($this->getScheduleByDay($day)){
            $work = 'close';
        foreach($this->getScheduleByDay($day) as $val){
            if($val['time_from']<=$time&& $time<$val['time_to']){
                $work = true;
                break;
            }
        }
        return $work;

        }
        else
            return 'free day';
    }

    public function getScheduleByDay($id){
        if(!isset($this->shedules[$id])){
            if($this->{$this->getDayByDayId($id)}){
                $model = ScheduleDaysTemplate::model()->findByPk($this->{$this->getDayByDayId($id)});
                $timeRange = [];
                if($model->timeRanges){
                foreach($model->timeRanges as $val){
                    $timeRange[] = ['time_from'=>$val->time_from,'time_to'=>$val->time_to, ];
                }
                    $this->shedules[$id] = $timeRange;
                }else
                $this->shedules[$id] = null;
            }
            else{
                $this->shedules[$id] = null;
            }


        }
        return $this->shedules[$id];
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('default','Name'),
			'category_id' => Yii::t('default','Category'),
            'category_list' => Yii::t('default','Services'),
            'addon_list' =>Yii::t('default','Add-ons'),
			'merchant_id' => Yii::t('default','Merchant'),
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
        if($this->category_id){
            $criteria->with = 'staff_has_category';
            $criteria->together= true;
            $criteria->addCondition('staff_has_category.category_id=:staff_has_category');
            $criteria->params = [':staff_has_category'=>$this->category_id];
        }
        $criteria->addCondition('merchant_id='.Yii::app()->user->id);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getLimit(){
        if(!Yii::app()->user->isGuest){
          return  Yii::app()->user->model->package? Yii::app()->user->model->package->workers_limit <= Staff::model()->countByAttributes(['merchant_id'=>Yii::app()->user->id]):false;
        }
       return false;
    }

    public function getFreeTime($d,$m,$u)
    {
        $s = StaffSchedule::model()->findByAttributes(['work_date'=>$d,'staff_id'=>$this->id]);
        $res = [];
        if($s){
            if($s->scheduleDaysTemplate){
                foreach($s->scheduleDaysTemplate->timeRanges as $val){
                    $va = $val->time_from;
                    do{
                        $res[] =$va;
                        $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                    }while($va<$val->time_to);
                }
            }
        }else{
            if($this->lastSchedule->{strtolower(date('D',strtotime($d)))}){
                $tr = ScheduleDaysTemplate::model()->findByPk($this->lastSchedule->{strtolower(date('D',strtotime($d)))});

                foreach($tr->timeRanges as $val){

                    $va = $val->time_from;
                    $t_to = date('H:i',strtotime("-$m minutes", strtotime($val->time_to)));
                    if($va<$t_to)
                        do{
                            $res[] =$va;
                            $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                        }while($va < $t_to);
                }
            }
        }
        
        //print_r($res);
        
        

        foreach($res as $key => $val){
            
            
            if(!SingleScheduleHelper::issetOrder($d,$val,$m,$this->id,$u)){
                unset($res[$key]);
            }
            
            
        }
        return $res;
    }

    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->staffShedAttr){
                $ss = new StaffScheduleHistory();
                $ss->attributes  = $this->staffShedAttr;
                $change = false;
                $om = $this->lastSchedule;
                if(empty($om))
                    $change = true;
                else
                    foreach(array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $key){
                        if(($ss->attributes[$key]||$om->attributes[$key])&&($ss->attributes[$key] != $om->attributes[$key])){
                            $change = true; break;
                        }
                    }

                if($change){
                    $ss->id = '';
                    $ss->staff_id = $this->id;
                    $ss->save();
                }
            }
        }
        return true;
    }
}
