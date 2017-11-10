<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mt_merchant_cc".
 *
 * @property integer $mt_id
 * @property integer $merchant_id
 * @property string $card_name
 * @property string $credit_card_number
 * @property string $expiration_month
 * @property string $expiration_yr
 * @property string $cvv
 * @property string $billing_address
 * @property string $date_created
 * @property string $ip_address
 */
class MtMerchantCc extends \yii\db\ActiveRecord
{
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_merchant_cc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_name', 'credit_card_number', 'expiration_month', 'expiration_yr', 'cvv', 'billing_address'], 'required'],
            [['merchant_id'], 'integer'],
            [['billing_address'], 'email'],
            [['date_created'], 'safe'],
            [['card_name', 'billing_address'], 'string', 'max' => 255],
            [['credit_card_number', 'cvv'], 'string', 'max' => 20],
            [['expiration_month', 'expiration_yr'], 'string', 'max' => 5],
            [['ip_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mt_id' => 'Mt ID',
            'merchant_id' => 'Merchant ID',
            'card_name' => 'Card Name',
            'credit_card_number' => 'Credit Card Number',
            'expiration_month' => 'Expiration Month',
            'expiration_yr' => 'Expiration Yr',
            'cvv' => 'Cvv',
            'billing_address' => 'Billing Address',
            'date_created' => 'Date Created',
            'ip_address' => 'Ip Address',
        ];
    }
    
    public static function getMonth(){
        $month = [];
        
        for ($i=1; $i<=12; $i++){
            $month[$i] = sprintf("%02d", $i);
            
        }
        
        return $month;
    }
    
    public static function getYear(){
        $year = [];
        for($i=date('Y'); $i<=(date('Y') + 10); $i++){
            $year[$i] = $i;
            
        }
         
        return $year;
    }
    
}
