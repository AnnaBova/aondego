<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "seo".
 *
 * @property integer $id
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keyword
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 */
class Seo extends \yii\db\ActiveRecord
{
    
    static $type = [
        '1' => 'Home Page',
        '2' => 'Search Page',
        '3' => 'Checkout Page',
        '4' => 'Merchant Signup Page',
        
        
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
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
            [['title','meta_description', 'meta_keyword', 'type'], 'required'],
            [['type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'title' => Yii::t('basicfield', 'Title'),
            'meta_description' => Yii::t('basicfield', 'Meta Description'),
            'meta_keyword' => Yii::t('basicfield', 'Meta Keyword'),
            'type' => Yii::t('basicfield', 'Type'),
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
