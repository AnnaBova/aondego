<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "merchant_appointment_cancel_setup".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $cancel_hour
 * @property string $cancel_percent
 * @property string $created_at
 * @property string $updated_at
 */
class MerchantAppointmentCancelSetup extends \yii\db\ActiveRecord
{
	
	static $type = [
	    '0' => 'After',
	    '1' => 'Before',
	    
	];
	
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
    public static function tableName()
    {
        return 'merchant_appointment_cancel_setup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'cancel_hour_from', 'cancel_hour_to', 'cancel_percent'], 'required'],
            [[ 'cancel_hour_from', 'cancel_hour_to', 'merchant_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cancel_percent'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('basicfield', 'ID'),
            'type' => Yii::t('basicfield', 'Type'),
            'cancel_hour' => Yii::t('basicfield', 'Cancel Hour'),
            'cancel_percent' => Yii::t('basicfield', 'Cancel Percent'),
            'created_at' => Yii::t('basicfield', 'Date Created'),
            'updated_at' => Yii::t('basicfield', 'Date Modified'),
	    'cancel_hour_from' => Yii::t('basicfield', 'Cancel Hour From'),
	    'cancel_hour_to' => Yii::t('basicfield', 'Cancel Hour To'),
        ];
    }

    /**
     * @inheritdoc
     * @return MerchantAppointmentCancelSetupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MerchantAppointmentCancelSetupQuery(get_called_class());
    }
    
	public function afterFind()
	{

		$dateFormat = \common\components\Helper::showDateFormat($this->merchant);
		$timeFormat = \common\components\Helper::showTimeFormat($this->merchant);
		
		$this->created_at = date("$dateFormat $timeFormat", strtotime($this->created_at));
		$this->updated_at = date("$dateFormat $timeFormat", strtotime($this->updated_at));


		parent::afterFind();
	}
	
	
	public function getMerchant(){
		
		return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id']);
	}
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
			 if(!empty($this->created_at)) $this->created_at = date("Y-m-d", strtotime($this->created_at));
			
		}
	}
}
