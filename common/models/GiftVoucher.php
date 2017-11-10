<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gift_voucher".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property double $amount
 * @property integer $service
 * @property string $services
 * @property string $expire_at
 * @property integer $merchant_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class GiftVoucher extends \yii\db\ActiveRecord
{
	
	static $type = [
	    'Fixed Amount',
	    'One service',
	    'Package of services',
	    
	];
	/**
     * @inheritdoc
     */
	public static function tableName()
	{
	    return 'gift_voucher';
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'amount'], 'required', 'on' => 'fixed'],
	    [['name', 'type', 'service'], 'required', 'on' => 'service'],
	    [['name', 'type', 'services'], 'required', 'on' => 'services'],
            [['type', 'service', 'merchant_id', 'status'], 'integer'],
            [['amount'], 'number'],
            [['expire_at', 'created_at', 'updated_at','service', 'services'], 'safe'],
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
            'type' => Yii::t('basicfield', 'Type'),
            'amount' => Yii::t('basicfield', 'Amount'),
            'service' => Yii::t('basicfield', 'Service'),
            'services' => Yii::t('basicfield', 'Services'),
            'expire_at' => Yii::t('basicfield', 'Expire Date'),
            'merchant_id' => Yii::t('basicfield', 'Merchant ID'),
            'status' => Yii::t('basicfield', 'Is Active'),
            'created_at' => Yii::t('basicfield', 'Created Date'),
            'updated_at' => Yii::t('basicfield', 'Updated Date'),
        ];
    }
    
	public function beforeSave($insert){
		if(parent::beforeSave($insert)){
			$this->merchant_id = Yii::$app->user->id;
			$this->services = json_encode($this->services);
			$this->created_at = date("Y-m-d H:i:s");
			$this->updated_at = date("Y-m-d H:i:s");
			if(!empty($this->expire_at))$this->expire_at = date("Y-m-d H:i:s", strtotime($this->expire_at));
			
			return true;
		} else
			return false;
	}
	
	public function afterFind()
	{
		$this->services = json_decode($this->services);
		if(!empty($this->expire_at))$this->expire_at = date('d-m-Y H:i:s', strtotime($this->expire_at));
		$this->updated_at = date('d-m-Y H:i:s', strtotime($this->updated_at));
		$this->created_at = date('d-m-Y H:i:s', strtotime($this->created_at));

		parent::afterFind();
	}
	
	public function getServiceName(){
		return $this->hasOne(\common\models\CategoryHasMerchant::className(), ['id' => 'service']);
	}
	
	public function getServicesName(){
		$categoryHasMerchant = "";
		if(!empty($this->services)){
		
			$categoryHasMerchant = CategoryHasMerchant::find()->where('id in ('.implode(',', $this->services).')')->all();
		}
		return $categoryHasMerchant;
	}
	
}
