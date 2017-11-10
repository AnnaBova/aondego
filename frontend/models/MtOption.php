<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mt_option".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property string $option_name
 * @property string $option_value
 */
class MtOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id'], 'integer'],
            [['option_name', 'option_value'], 'required'],
            [['option_value'], 'string'],
            [['option_name'], 'string', 'max' => 255],
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
            'option_name' => 'Option Name',
            'option_value' => 'Option Value',
        ];
    }
}
