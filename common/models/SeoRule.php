<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "seo_rule".
 *
 * @property integer $id
 * @property string $name
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $created_at
 * @property string $updated_at
 */
class SeoRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_rule';
    }
    
    public function behaviors() {
        return [
            'timestamp'=>[
            'class'=>TimestampBehavior::className(),
            'value' => new Expression('NOW()'),                                    
            ]
        ];
        
        parent::behaviors();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_title', 'meta_description', 'meta_keyword'], 'string'],
            [['created_at', 'updated_at','type'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'name' => Yii::t('basicfield', 'Name'),
            'meta_title' => Yii::t('basicfield', 'Meta Title'),
            'meta_description' => Yii::t('basicfield', 'Meta Description'),
            'meta_keyword' => Yii::t('basicfield', 'Meta Keyword'),
            'created_at' => Yii::t('basicfield', 'Created At'),
            'updated_at' => Yii::t('basicfield', 'Updated At'),
        ];
    }
    
    public function afterFind(){
        $this->created_at = date('d-m-Y H:i:s', strtotime($this->created_at));
        $this->updated_at = date('d-m-Y H:i:s', strtotime($this->updated_at));

        parent::afterFind();
    }
}
