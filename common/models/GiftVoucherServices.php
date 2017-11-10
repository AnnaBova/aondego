<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gift_voucher_services".
 *
 * @property integer $id
 * @property integer $gift_voucher_id
 * @property integer $category_has_merchant_id
 * @property string $created_at
 * @property string $updated_at
 */
class GiftVoucherServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gift_voucher_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gift_voucher_id', 'category_has_merchant_id', 'created_at'], 'required'],
            [['gift_voucher_id', 'category_has_merchant_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'gift_voucher_id' => Yii::t('basicfield', 'Gift Voucher ID'),
            'category_has_merchant_id' => Yii::t('basicfield', 'Category Has Merchant ID'),
            'created_at' => Yii::t('basicfield', 'Created At'),
            'updated_at' => Yii::t('basicfield', 'Updated At'),
        ];
    }
}
