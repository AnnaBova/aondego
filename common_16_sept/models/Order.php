<?php

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
class Order extends CActiveRecord
{
    public $count_by_date, $date_of_order;
    public $order_date, $free_time, $free_time_list;
    public $addons_list;


    const SOURCE_PHONE = 1;

    public static function getOrderStatuses()
    {
        return [0 => Yii::t('default', 'pre order'), 1 => Yii::t('default', 'ordered'), '2' => Yii::t('default', 'canceled'), 3 => Yii::t('default', 'moved')];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function  primaryKey()
    {
        return 'id';
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'order';
    }
    public function behaviors()
    {
        return array(
            'CAdvancedArBehavior' => array(
                'class' => 'site.common.extensions.CAdvancedArBehavior'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status' => Yii::t('default','Status'),
            'client_id' => Yii::t('default','Client'),
            'payment_type' => Yii::t('default','Payment Type'),
            'client_name' => Yii::t('default','Client Name'),
            'client_phone' => Yii::t('default','Client Phone'),
            'client_email' => Yii::t('default','Client Email'),
            'order_time' => Yii::t('default','Order Time'),
            'category_id' => Yii::t('default','Service'),
            'free_time' => Yii::t('default','Client time'),
            'more_info' => Yii::t('default','More Info'),
            'price' => Yii::t('default','Price'),
            'merchant_id' => Yii::t('default','Merchant'),
            'is_group' => Yii::t('default','Is Group Order'),
            'staff_id'=> Yii::t('default','Staff'),
            'addons_list' => Yii::t('default','Add-ons List'),
            'create_time' => Yii::t('default', 'Creation Time'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_time, category_id', 'required'),
            array('status, staff_id, client_id, payment_type, category_id, merchant_id', 'numerical', 'integerOnly' => true),
            array('client_name, client_phone, client_email,free_time, free_time_list', 'length', 'max' => 50),
            ['order_time, order_date, addons_list', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, status, client_id, payment_type, client_name, client_phone,is_group, client_email, order_time, category_id', 'safe', 'on' => 'search'),
        );
    }



    public function beforeSave()
    {
        if ($this->isNewRecord) $this->merchant_id = Yii::app()->user->id;
        if ($this->isNewRecord) $this->order_id = time() . $this->category_id;
        if ($this->isNewRecord) $this->source_type = self::SOURCE_PHONE;
        if($this->isNewRecord) $this->create_time = date("Y-m-d H:i:s");
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->price = Yii::app()->format->number($this->price);
        parent::afterFind();
    }

    public function beforeValidate() {
        $this->price = Yii::app()->format->unformatNumber($this->price);
        return parent::beforeValidate();
    }
    public function remove(){
        $this->status = 2;
        $this->save(false);
    }
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('status', $this->status);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('is_group', $this->is_group);
        $criteria->compare('payment_type', $this->payment_type);
        $criteria->compare('client_name', $this->client_name, true);
        $criteria->compare('client_phone', $this->client_phone, true);
        $criteria->compare('client_email', $this->client_email, true);
        $criteria->compare('order_time', $this->order_time, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->addCondition('status != 2');

        $criteria->addCondition('merchant_id=' . Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getOrderTimeLength()
    {
        
        return $this->category->getTimeOfService() + $this->getAddonsTimeLength();
    }

    public function getAddonsTimeLength()
    {
        $l =0;
        foreach($this->addons as $val){
            $l += $val->time_in_minutes;
        }
        return $l;
    }
}
