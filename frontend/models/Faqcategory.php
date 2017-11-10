<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "faqcategory".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Faqs[] $faqs
 */
class Faqcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faqcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaqs()
    {
        return $this->hasMany(Faqs::className(), ['faqcategory_id' => 'id']);
    }
}
