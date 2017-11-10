<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merchant_package_order".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $package_id
 * @property string $item_name
 * @property string $price
 * @property string $txn_id
 * @property string $payment_status
 * @property integer $payment_type
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $created_at
 * @property string $updated_At
 */
class MerchantPackageOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_package_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'package_id', 'payment_type'], 'integer'],
            [['created_at', 'updated_At'], 'safe'],
            [['item_name', 'price', 'txn_id', 'first_name', 'last_name', 'email'], 'string', 'max' => 100],
            [['payment_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'merchant_id' => Yii::t('basicfield', 'Merchant ID'),
            'package_id' => Yii::t('basicfield', 'Package ID'),
            'item_name' => Yii::t('basicfield', 'Item Name'),
            'price' => Yii::t('basicfield', 'Price'),
            'txn_id' => Yii::t('basicfield', 'Txn ID'),
            'payment_status' => Yii::t('basicfield', 'Payment Status'),
            'payment_type' => Yii::t('basicfield', 'Payment Type'),
            'first_name' => Yii::t('basicfield', 'First Name'),
            'last_name' => Yii::t('basicfield', 'Last Name'),
            'email' => Yii::t('basicfield', 'Email'),
            'created_at' => Yii::t('basicfield', 'Created At'),
            'updated_At' => Yii::t('basicfield', 'Updated  At'),
        ];
    }
}
