<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "faqs".
 *
 * @property integer $id
 * @property integer $categorytitle_id
 * @property string $question
 * @property string $answer
 *
 * @property Categorytitle $categorytitle
 */
class Faqs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faqs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categorytitle_id', 'question', 'answer'], 'required'],
            [['categorytitle_id'], 'integer'],
            [['answer'], 'string'],
            [['question'], 'string', 'max' => 250],
            [['categorytitle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorytitle::className(), 'targetAttribute' => ['categorytitle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categorytitle_id' => 'Categorytitle ID',
            'question' => 'Question',
            'answer' => 'Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorytitle()
    {
        return $this->hasOne(Categorytitle::className(), ['id' => 'categorytitle_id']);
    }
}
