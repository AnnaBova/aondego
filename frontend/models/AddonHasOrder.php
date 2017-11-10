<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "addon_has_order".
 *
 * @property integer $addon_id
 * @property integer $order_id
 *
 * @property Addon $addon
 * @property Order $order
 */
class AddonHasOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addon_has_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addon_id', 'order_id'], 'required'],
            [['addon_id', 'order_id'], 'integer'],
            [['addon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addon::className(), 'targetAttribute' => ['addon_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'addon_id' => 'Addon ID',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddon()
    {
        return $this->hasOne(Addon::className(), ['id' => 'addon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
