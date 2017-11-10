<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_birthday_coupon".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $user_id
 * @property string $code
 * @property string $year
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserBirthdayCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_birthday_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'voucher_id'], 'safe'],
            [['code'], 'string', 'max' => 200],
            [['year'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'user_id' => 'User ID',
            'code' => 'Code',
            'year' => 'Year',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getVoucher(){
        return $this->hasOne(Voucher::className(),[ 'voucher_id', 'voucher_id']);
    }
}
