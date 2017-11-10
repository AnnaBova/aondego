<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "messagebird_details".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property string $access_key
 */
class MessagebirdDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $enable=1,$sms_type=1;
    public static function tableName()
    {
        return 'messagebird_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'access_key'], 'required'],
            [['merchant_id'], 'integer'],
            [['access_key'], 'string', 'max' => 250],
            [['created_at,updatedat'],'safe'],
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
            'access_key' => Yii::t('basicfield', 'Access Key'),
            'created_at' => Yii::t('basicfield', 'Created At'),
            'updated_at' => Yii::t('basicfield', 'Updated At'),
        ];
    }
}
