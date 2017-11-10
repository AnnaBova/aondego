<?php
namespace common\models;
use yii\db\ActiveRecord;
use common\models\Addon;

use common\models\GroupScheduleDaysTemplate;
use common\models\Staff;
use Yii;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;

/**
 * This is the model class for table "category_has_merchant".
 *
 * The followings are the available columns in table 'category_has_merchant':
 * @property integer $category_id
 * @property integer $merchant_id
 * @property integer $time_in_minutes
 * @property integer $additional_time
 * @property double $price
 * @property string $color
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Staff[] $staff
 * @property Addon[] $addons
 * @property Staff[] $staff1
 */
class CategoryHasMerchant extends ActiveRecord
{
    public $oneMany = [];
    public static function primaryKey(){
        return ['id'];
    }

    public $cat_id;

    const STEPS = 12;
    const TIME_SLOT_STEP = 15;

    const UPLOAD_DIR = 'service';
    public $image;
    
    public $editableAddons = [];
    
    //public $addons = "";


    public $addon_list = [];


    public static $allColors = ['#ef9a9a','#f48fb1','#ce93d8','#b71c1c','#880e4f','#4a148c','#311b92','#1976d2','#4fc3f7','#4db6ac',
    '#1de9b6','#66bb6a','#d4e157','#1b5e20','#827717','#ffeb3b','#f57c00','#795548','#757575','#ff3d00','#ff1744'];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'category_has_merchant';
	}

    public function getModel(){
        return $this;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		return [
			[['category_id', 'title', 'merchant_id', 'price'], 'required'],
                        ['service_time_slot', 'required', 'on'=>'single'],
                        [['category_id', 'additional_time', 'service_time_slot', 'merchant_id', 'is_active', 'time_in_minutes', 'group_people', 'staff_id'],'integer'],
                        ['price', 'integer'],
                        ['image', 'image', 'extensions'=>'jpg, png'],
                        [['title', 'color'], 'string', 'max'=>255],
                        [['addon_list', 'oneMany', 'description', 'editableAddons'],'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['category_id, merchant_id, price', 'safe', 'on'=>'search'],
		];
	}
        
        
    public function behaviors(){
        return array(
//            'CAdvancedArBehavior' => array(
//                'class' => 'site.common.extensions.CAdvancedArBehavior'),
            'imageBehavior' => array(
                'class' => \common\extensions\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ),
            'oneManyBehavior' => array(
                'class' => \common\extensions\OneManyBehavior::className(),
                'fields'=> [
                    [   'attr'=>'schedule_days_template_id',
                        'label'=>'Schedule Days Template',
                        'type'=>'dropDown',
                        'data'=>\yii\Helpers\ArrayHelper::map(GroupScheduleDaysTemplate::find()->where(['merchant_id'=>(Yii::$app->user->isGuest ? 0 : Yii::$app->user->id)])->all(),'id','title')
                        ],
                    ['attr'=>'reason','label'=>'Reason','type'=>'textInput'],['attr'=>'work_date','label'=>'Date','type'=>'date']],
                'relation' => 'groupSchedules',
                'relationModel' => '\common\models\GroupSchedule',
                'parent_column_name' => 'group_id'
            ),
            [
            'class' => ManyToManyBehavior::className(),
            'relations' => [
                        
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
            'subcategory' => [self::BELONGS_TO, 'ServiceSubcategory','category_id'],
            'merchant' => [self::BELONGS_TO, 'Merchant','merchant_id'],
            'addons' => array(self::MANY_MANY, 'Addon', 'merch_cat_has_addon(m_c_id, addon_id)'),
            'm_c_has_addon' => [self::HAS_MANY,'MerchCatHasAddon', 'm_c_id'],
            'lastSchedule' => array(self::HAS_ONE, 'GroupScheduleHistory', 'group_id','order'=>'id DESC'),
            'schedule' => array(self::HAS_MANY, 'GroupScheduleHistory', 'group_id'),
            'groupSchedules' => array(self::HAS_MANY, 'GroupSchedule', 'group_id'),
            'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}
        
        public function getGroupSchedules()
        {
            return $this->hasMany(GroupSchedule::className(), ['group_id' => 'id']);
        }
        
        public function getM_c_has_addon(){
            return $this->hasMany(MerchCatHasAddon::className(), ['m_c_id' => 'id']);
        }
        
        

    public static  function getTimeSlots(){
        $ts = [];
        for($i=1; $i<=self::STEPS; $i++){
            $ts[self::TIME_SLOT_STEP*$i] = (self::TIME_SLOT_STEP*$i).' min';
        }
        return $ts;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => Yii::t('basicfield','Subcategory'),
            'cat_id' => Yii::t('basicfield','Category'),
			'merchant_id' => Yii::t('basicfield','Merchant'),
			'price' => Yii::t('basicfield','Price'),
            'time_in_minutes'=>Yii::t('basicfield','Time in minutes'),
            'additional_time' => Yii::t('basicfield','Additional Time'),
            'service_time_slot' => Yii::t('basicfield','Service Time Slot'),
            'addon_list' =>Yii::t('basicfield','Add-ons'),
            'group_people' => Yii::t('basicfield','Peoples In Group'),
            'title' => Yii::t('basicfield','Title'),
            'staff_id' => Yii::t('basicfield','Staff'),
            'color'=>Yii::t('basicfield','Color'),
            'description'=>Yii::t('basicfield','Description'),
                    'is_active'=>Yii::t('basicfield','Is Active'),
                    'image'=>Yii::t('basicfield','Image'),
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

		$criteria->compare('category_id',$this->category_id);

                $criteria->compare('is_active',$this->is_active);
		$criteria->compare('price',$this->price);
                $criteria->addCondition('merchant_id='.Yii::app()->user->id);
                $criteria->addCondition('is_group=0');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchGroup()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('category_id',$this->category_id);

        $criteria->compare('is_active',$this->is_active);
        $criteria->compare('price',$this->price);
        $criteria->addCondition('merchant_id='.Yii::app()->user->id);
        $criteria->addCondition('is_group=1');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryHasMerchant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterFind() {
        //$this->price = Yii::app()->format->number($this->price);
        if($this->category_id)$this->cat_id = $this->subcategory?$this->subcategory->category_id:null;
         parent::afterFind();
    }

    public function beforeValidate() {
        $this->price = Yii::$app->format->unformatNumber($this->price);

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if(empty($this->color)){
            $usedColors = \yii\helpers\ArrayHelper::map(self::find()->where(['merchant_id'=>Yii::$app->user->id]),'id','color');
            $unusedColors = array_diff(self::$allColors,$usedColors);
            $this->color = $unusedColors[array_rand($unusedColors)];
        }
        return parent::beforeSave($insert);
    }

    public function getTimeOfService(){
        return $this->time_in_minutes + $this->additional_time;
    }

    public function getTitleWithPriceAndTime(){
        return $this->title. ' '.$this->time_in_minutes.'/'.$this->price;
    }
    
    
    public function getSubcategory()
    {
        return $this->hasOne(ServiceSubcategory::className(), ['id' => 'category_id']);
    }
    
    public function getLastSchedule()
    {
        return $this->hasOne(GroupScheduleHistory::className(), ['group_id' => 'id'])->orderBy('id desc');
    }
    
    public function getAddons()
    {   
        return $this
       ->hasMany(Addon::className(), ['id' => 'addon_id'])
       ->viaTable('merch_cat_has_addon', ['m_c_id' => 'id']);
        
    }
    
}
