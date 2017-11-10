<?php
namespace common\models;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-May-16
 * Time: 20:44
 */

class SingleOrder extends Order {

    public $memcache_key, $birthday;
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['order_time', 'category_id', 'staff_id', 'client_name', 'client_phone', 'client_email', 'free_time_list'], 'required'],
            [['status', 'staff_id', 'client_id', 'payment_type', 'category_id', 'merchant_id'], 'integer'],
            [['client_name', 'client_phone', 'client_email','free_time', 'free_time_list'], 'string', 'max' => 50],
            [['order_time', 'order_date', 'addons_list', 'memcache_key', 'birthday'], 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('id, status, client_id, payment_type, client_name, client_phone, client_email, order_time, category_id', 'safe', 'on' => 'search'),
        ];
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('status', $this->status);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('payment_type', $this->payment_type);
        $criteria->compare('client_name', $this->client_name, true);
        $criteria->compare('client_phone', $this->client_phone, true);
        $criteria->compare('client_email', $this->client_email, true);
        $criteria->compare('order_time', $this->order_time, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->addCondition('status != 2');
        $criteria->addCondition('is_group = 0');
        $criteria->addCondition('merchant_id=' . Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterSave($insert, $changedAttributes)
    {
        CachedSingleOrder::deleteCacheByStaffDAteID($this->staff_id,$this->order_time,$this->memcache_key);
        parent::afterSave($insert, $changedAttributes);
    }

} 