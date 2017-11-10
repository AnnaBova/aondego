<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "addon_has_staff".
 *
 * @property integer $id
 * @property integer $staff_id
 * @property integer $addon_id
 *
 * @property Addon $addon
 * @property Staff $staff
 */
class AddonHasStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addon_has_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'addon_id'], 'required'],
            [['staff_id', 'addon_id'], 'integer'],
            [['addon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addon::className(), 'targetAttribute' => ['addon_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'addon_id' => 'Addon ID',
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
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
