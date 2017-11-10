<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
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
class Staff extends ActiveRecord
{

    public static function primaryKey(){
        return ['id'];
    }
    const UPLOAD_DIR = 'staff';
    public $image;
    public $category_list = [];
    public $addon_list = [];

    public $category_id;

    private $shedules = [];

    public $oneMany = [];
    public $oneMany2 = [];
    public $editableCategories = [];
    public $editableAddons = [];

    public  $staffShedAttr;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
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
		return [
			[['name', 'merchant_id'], 'required'],
			[['merchant_id', 'is_active'],'integer'],
			['name', 'string', 'max'=>45],
            ['image', 'image', 'extensions'=>'jpg, png'],
                   [['editableCategories', 'description'], 'safe'],
            [['category_id', 'category_list', 'addon_list', 'oneMany', 'oneMany2', 'categories', 'addons'],'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['id, name,category_id', 'safe', 'on'=>'search'),
		];
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
                'class' => \common\extensions\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ),
//            'CAdvancedArBehavior' => array(
//                'class' => 'site.common.extensions.CAdvancedArBehavior'),
            'oneManyBehavior' => array(
                'class' => \common\extensions\OneManyBehavior::className(),
                'fields'=> [['attr'=>'schedule_days_template_id','label'=>'Schedule Days Template','type'=>'dropDown','data'=>\yii\Helpers\ArrayHelper::map(ScheduleDaysTemplate::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','title')],
                    ['attr'=>'reason','label'=>'Reason','type'=>'textInput'],
                    ['attr'=>'work_date','label'=>'Date','type'=>'date'],
                    //['attr'=>'work_time','label'=>'Time','type'=>'time']
                    ],
                'relation' => 'futureStaffSchedules',
                'relationModel' => '\common\models\StaffSchedule',
                'parent_column_name' => 'staff_id'
            ),

            'vacationBehavior' => array(
                'class' => \common\extensions\OneManyBehavior::className(),
                'oneManyField' => 'oneMany2',
                'fields'=> [
                    ['attr'=>'remark','label'=>'Reason','type'=>'textInput'],['attr'=>'start_date','label'=>'Start Date','type'=>'date'],['attr'=>'end_date','label'=>'End Date','type'=>'date']],
                'relation' => 'futureStaffVacations',
                'relationModel' => '\common\models\StaffVacation',
                'parent_column_name' => 'staff_id'
            ),
            [
            'class' => ManyToManyBehavior::className(),
            'relations' => [
                        [
                            'name' => 'categories',
                            // This is the same as in previous example
                            'editableAttribute' => 'editableCategories',
                        ],
                        [
                            'name' => 'addons',
                            // This is the same as in previous example
                            'editableAttribute' => 'editableAddons',
                        ],
                    ],
            ]
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
	
	public function getMerchant(){
		return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id']);
	}
        
        
        public function getAddons()
        {

            return $this
           ->hasMany(Addon::className(), ['id' => 'addon_id'])
           ->viaTable('addon_has_staff', ['staff_id' => 'id']);

        }
        public function getGroupCat(){
            return $this->hasMany(CategoryHasMerchant::className(), ['staff_id' => 'id']);
        }
        
        public function getFutureFreeStaffSchedules(){
            return $this->hasMany(StaffSchedule::className(), ['staff_id' => 'id'])->where('work_date>="'.date('Y-m-d').'" AND schedule_days_template_id is NULL');
        }
        
        public function getFutureOrders(){
            return $this->hasMany(SingleOrder::className(), ['staff_id' => 'id'])->where('order_time>="' . date('Y-m-d') . ' 00:00:00" and is_group= 0 AND status!=2');
        }
        
        public function getStaff_has_category()
        {   
            return $this
           ->hasMany(StaffHasCategory::className(), ['staff_id' => 'id']);
        }
        
        
        public function getAddon_has_staff()
        {   
            return $this
           ->hasMany(AddonHasStaff::className(), ['staff_id' => 'id']);
        }
        
        
        public function getFutureStaffSchedules()
        {   
            return $this
           ->hasMany(StaffSchedule::className(), ['staff_id' => 'id'])->where('work_date>="'.date('Y-m-d').'"');
        }
        
        public function getFutureStaffVacations()
        {   
            return $this
           ->hasMany(StaffVacation::className(), ['staff_id' => 'id'])->where('end_date>="'.date('Y-m-d').'"');
        }
        
        public function getStaffVacations()
        {   
            return $this
           ->hasMany(StaffVacation::className(), ['staff_id' => 'id']);
        }
        
        public function getCategories()
        {

            return $this
           ->hasMany(CategoryHasMerchant::className(), ['id' => 'category_id'])
           ->viaTable('staff_has_category', ['staff_id' => 'id']);

        }
        
        public function getLastSchedule()
        {
            return $this->hasOne(StaffScheduleHistory::className(), ['staff_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
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
			'name' => Yii::t('basicfield','Name'),
			'category_id' => Yii::t('basicfield','Category'),
                        'category_list' => Yii::t('basicfield','Services'),
                        'addon_list' =>Yii::t('basicfield','Add-ons'),
			'merchant_id' => Yii::t('basicfield','Merchant'),
                        'image' => Yii::t('basicfield','Image'),
                        'is_active' => Yii::t('basicfield','Is Active'),
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
        $merchantS = \common\models\MerchantSchedule::find()->where(['work_date' => $d, 'merchant_id' => Yii::$app->user->id])->one();
        $s = StaffSchedule::find()->where(['work_date'=>$d,'staff_id'=>$this->id])->one();
        $res = [];
        
        
        if($merchantS){
            
            if($merchantS->scheduleDaysTemplate){
                foreach($merchantS->scheduleDaysTemplate->timeRanges as $val){
                    $va = $val->time_from;
                    $to = date('H:i', strtotime("-$m minutes", strtotime($val->time_to)));
                    do{
                        $res[] =$va;
                        $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                    }while($va <= $to);
                }
            }
            
        }
        else if($s){
            if($s->scheduleDaysTemplate){
                foreach($s->scheduleDaysTemplate->timeRanges as $val){
                    $va = $val->time_from;
                    $to = date('H:i', strtotime("-$m minutes", strtotime($val->time_to)));
                    do{
                        $res[] =$va;
                        $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                    }while($va <= $to);
                }
            }
        }else{
            if($this->lastSchedule->{strtolower(date('D',strtotime($d)))}){
                $tr = ScheduleDaysTemplate::findOne($this->lastSchedule->{strtolower(date('D',strtotime($d)))});

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
        
        
        //exit;
        
        
        
        

        foreach($res as $key => $val){
            
            
            $grupSchedule = \common\extensions\GroupScheduleHelper::checkGroupServices($this->groupCat, $d, $val, $m);
            
            if(!$grupSchedule){
                //echo '';
                unset($res[$key]);
            }
            
            
            //exit;
            
            
            if(!\common\extensions\SingleScheduleHelper::issetOrder($d,$val,$m,$this->id,$u)){
                
                unset($res[$key]);
            }
            
            
            
            
        }
        
//        print_r($res);
//        exit;
        return $res;
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
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
