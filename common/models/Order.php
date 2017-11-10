<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $status
 * @property integer $client_id
 * @property integer $payment_type
 * @property string $client_name
 * @property string $client_phone
 * @property string $client_email
 * @property string $order_time
 * @property integer $category_id
 * @property integer $staff_id
 * @property datetime $create_time
 * @property integer $is_group
 * @property integer $source_type
 * @property integer $order_id
 * @property float $price
 *
 * The followings are the available model relations:
 * @property Addon[] $addons
 *  @property Staff $staff
 * @property CategoryHasMerchant $category
 * @property Client $client
 */
class Order extends ActiveRecord
{
    public $count_by_date, $date_of_order;
    public $order_date, $free_time, $free_time_list;
    public $addons_list;
    public $editableAddons = [];

    const SOURCE_PHONE = 1;

    public static function getOrderStatuses()
    {
        return [0 => Yii::t('basicfield', 'pre order'),
            1 => Yii::t('basicfield', 'ordered'),
            '2' => Yii::t('basicfield', 'canceled'),
            3 => Yii::t('basicfield', 'moved'), 
            '4' => Yii::t('basicfield', 'paypal pending')];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Order the static model class
     */
    

    public static function  primaryKey()
    {
        return ['id'];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'order';
    }
    public function behaviors()
    {
        return array(
            /*'CAdvancedArBehavior' => array(
                'class' => 'site.common.extensions.CAdvancedArBehavior'),*/
            
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
            'addons' => array(self::MANY_MANY, 'Addon', 'addon_has_order(order_id, addon_id)'),
            'category' => array(self::BELONGS_TO, 'CategoryHasMerchant', 'category_id'),
            'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
            'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
        );
    }
    
    public function getAddons()
    {
        return $this->hasMany(Addon::className(), ['id' => 'addon_id'])
                ->viaTable('addon_has_order', ['order_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status' => Yii::t('basicfield','Status'),
            'client_id' => Yii::t('basicfield','Client'),
            'payment_type' => Yii::t('basicfield','Payment Type'),
            'client_name' => Yii::t('basicfield','Client Name'),
            'client_phone' => Yii::t('basicfield','Client Phone'),
            'client_email' => Yii::t('basicfield','Client Email'),
            'order_time' => Yii::t('basicfield','Order Time'),
            'category_id' => Yii::t('basicfield','Service'),
            'free_time' => Yii::t('basicfield','Client time'),
            'more_info' => Yii::t('basicfield','More Info'),
            'price' => Yii::t('basicfield','Price'),
            'merchant_id' => Yii::t('basicfield','Merchant'),
            'is_group' => Yii::t('basicfield','Is Group Order'),
            'staff_id'=> Yii::t('basicfield','Staff'),
            'addons_list' => Yii::t('basicfield','Add-ons List'),
            'create_time' => Yii::t('basicfield', 'Creation Time'),
            'free_time_list' => Yii::t('basicfield', 'Free Time List'),
            'no_of_seats' => Yii::t('basicfield', 'No Of Seats')
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['order_time', 'category_id'], 'required'],
            [['status', 'staff_id', 'client_id', 'payment_type', 'category_id', 'merchant_id'], 'integer'],
            [['client_name', 'client_phone', 'client_email','free_time', 'free_time_list'], 'string', 'max' => 50],
            [['order_time', 'order_date', 'addons_list', 'loyalty_points', 
		'user_birthday_coupon_id', 'cancel_amount',
		'refund_transaction_id', 'cancel_reason',
		'is_delivered_pickup', 'currency'
		], 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('id, status, client_id, payment_type, client_name, client_phone,is_group, client_email, order_time, category_id', 'safe', 'on' => 'search'),
        ];
    }



    public function beforeSave($insert)
    {
        if ($this->isNewRecord) $this->merchant_id = Yii::$app->user->id;
        if ($this->isNewRecord) $this->order_id = time() . $this->category_id;
        //if ($this->isNewRecord) $this->source_type = self::SOURCE_PHONE;
        if($this->isNewRecord) $this->create_time = date("Y-m-d H:i:s");
        
        if(!empty($this->order_time) && $this->order_time != '0000-00-00 00:00:00')$this->order_time = date('Y-m-d H:i:s', strtotime($this->order_time)); 
		
        return parent::beforeSave($insert);
    }

    public function afterFind() {
        //$this->price = Yii::$app->format->number($this->price);
        
        //$this->order_time = date('d-m-Y H:i:s', strtotime($this->order_time)); 
        parent::afterFind();
    }

    public function beforeValidate() {
        $this->price = Yii::$app->format->unformatNumber($this->price);
        return parent::beforeValidate();
    }
    public function remove(){
        $this->status = 2;
        $this->save(false);
    }
//    public function search()
//    {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('id', $this->id);
//        $criteria->compare('status', $this->status);
//        $criteria->compare('client_id', $this->client_id);
//        $criteria->compare('is_group', $this->is_group);
//        $criteria->compare('payment_type', $this->payment_type);
//        $criteria->compare('client_name', $this->client_name, true);
//        $criteria->compare('client_phone', $this->client_phone, true);
//        $criteria->compare('client_email', $this->client_email, true);
//        $criteria->compare('order_time', $this->order_time, true);
//        $criteria->compare('category_id', $this->category_id);
//        $criteria->addCondition('status != 2');
//
//        $criteria->addCondition('merchant_id=' . Yii::$app->user->id);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }

    public function getOrderTimeLength()
    {
        
        return $this->category->getTimeOfService() + $this->getAddonsTimeLength();
    }

    public function getAddonsTimeLength()
    {
        $l =0;
        
        if($this->addons){
            foreach($this->addons as $val){
                $l += $val->time_in_minutes;
            }
        }
        return $l;
    }
    
    public function getCategory()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'category_id']);
    }
    
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    
    
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
    
    public function getMerchant()
    {
        return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id']);
    }
    
    public function getAddress()
    {
        return $this->hasOne(\frontend\models\MtAddressBook::className(), ['id' => 'address_id']);
    }
    
    public function getVoucher()
    {
        return $this->hasOne(\common\models\GiftVoucher::className(), ['id' => 'gift_voucher_id']);
    }
	
	public function  getReciever(){
		if($this->delivery_option == 0){
			return $this->client_name;   
		}else{
			return $this->address->first_name.' '.$this->address->last_name;
		}
	}
}
