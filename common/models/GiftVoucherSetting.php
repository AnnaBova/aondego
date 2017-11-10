<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gift_voucher_setting".
 *
 * @property integer $id
 * @property string $delivery_options
 * @property string $payment
 * @property double $delivery_fee
 * @property integer $receive_loyalty_points
 * @property integer $use_loyalty_points
 * @property integer $merchant_id
 * @property string $created_at
 * @property string $updated_at
 */
class GiftVoucherSetting extends \yii\db\ActiveRecord
{
	
	static $deliveryOption = [
	    'Pick Up',
	    'Regular Mail'
	];
	
	static $payment = [
	    'On Spot',
	    'Via Bank Transfer',
	    'Paypal'
	];
	
	
	static $deliverFree = [
	    'Is Free',
	    'the delivery fee applies',
	    
	];
	
	
	public static function deliveryOption(){
		$deliveryOption = [
			Yii::t('basicfield', 'Pick Up'),
			Yii::t('basicfield', 'Regular Mail')
		    ];
			
		return $deliveryOption;
	}
	
	public static function payment(){
		$payment = [
			Yii::t('basicfield', 'On Spot'),
			Yii::t('basicfield', 'Via Bank Transfer'),
			Yii::t('basicfield', 'Paypal')
		    ];
		
		return $payment;
	}
	
	public static function deliverFree(){
		$deliverFree = [
			Yii::t('basicfield', 'Is Free'),
			Yii::t('basicfield', 'the delivery fee applies'),

		    ];
		
		    return $deliverFree;
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gift_voucher_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_options', 'payment', 'delivery_fee', 'receive_loyalty_points', 'use_loyalty_points', 'merchant_id', 'created_at'], 'safe'],
            [['delivery_fee'], 'number'],
            [['receive_loyalty_points', 'use_loyalty_points', 'merchant_id'], 'integer'],
            [['created_at', 'updated_at', 'is_delivery_free'], 'safe'],
            //[['delivery_options', 'payment'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'delivery_options' => Yii::t('basicfield', 'Delivery Options'),
            'payment' => Yii::t('basicfield', 'Payment'),
            'delivery_fee' => Yii::t('basicfield', 'Delivery Fee'),
            'receive_loyalty_points' => Yii::t('basicfield', 'Receive Loyalty Points'),
            'use_loyalty_points' => Yii::t('basicfield', 'Use Loyalty Points'),
	    'is_delivery_free' => Yii::t('basicfield', 'Is Free'),
	    'merchant_id' => Yii::t('basicfield', 'Merchant ID'),
            'created_at' => Yii::t('basicfield', 'Created At'),
            'updated_at' => Yii::t('basicfield', 'Updated At'),
        ];
    }
    
	public function getMerchant(){
		
		return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id']);
	}
    
	public function afterFind()
	{
		$dateFormat = \common\components\Helper::showDateFormat($this->merchant);
		$timeFormat = \common\components\Helper::showTimeFormat($this->merchant);
		
		$this->created_at = date("$dateFormat $timeFormat", strtotime($this->created_at));
		$this->updated_at = date("$dateFormat $timeFormat", strtotime($this->updated_at));
		
		$this->delivery_options = json_decode($this->delivery_options);
		$this->payment = json_decode($this->payment);


		parent::afterFind();
	}
	
	public function beforeSave($insert){
		
        if(parent::beforeSave($insert)){
			if(!empty($this->updated_at)) $this->updated_at = date("Y-m-d H:i:s", strtotime($this->updated_at));
		}
	}
		
}
