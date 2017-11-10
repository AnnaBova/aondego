<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "group_time_range".
 *
 * @property integer $id
 * @property string $time_start
 * @property integer $group_schedule_days_template_id
 *
 * @property GroupScheduleDaysTemplate $groupScheduleDaysTemplate
 */
class GroupTimeRange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_time_range';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_start', 'group_schedule_days_template_id'], 'required'],
            [['group_schedule_days_template_id'], 'integer'],
            [['time_start'], 'string', 'max' => 45],
            [['group_schedule_days_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupScheduleDaysTemplate::className(), 'targetAttribute' => ['group_schedule_days_template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_start' => 'Time Start',
            'group_schedule_days_template_id' => 'Group Schedule Days Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupScheduleDaysTemplate()
    {
        return $this->hasOne(GroupScheduleDaysTemplate::className(), ['id' => 'group_schedule_days_template_id']);
    }
}
