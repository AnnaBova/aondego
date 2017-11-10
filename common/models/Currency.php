<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "mt_currency".
 *
 * @property string $currency_code
 * @property string $currency_symbol
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_currency';
    }
    
	public function behaviors(){
		return [

			[
			    'class' => TimestampBehavior::className(),
			    'createdAtAttribute' => 'date_created',
			    'updatedAtAttribute' => 'date_modified',
			    'value' => new Expression('NOW()'),
			],
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_code', 'currency_symbol'], 'required'],
            [['date_created', 'date_modified', 'ip_address'], 'safe'],
            [['currency_code'], 'string', 'max' => 3],
            [['currency_symbol'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currency_code' => Yii::t('basicfield', 'Currency Code'),
            'currency_symbol' => Yii::t('basicfield', 'Currency Symbol'),
            'date_created' => Yii::t('basicfield', 'Date Created'),
            'date_modified' => Yii::t('basicfield', 'Date Modified'),
            'ip_address' => Yii::t('basicfield', 'Ip Address'),
        ];
    }
}
