<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "{{voucher}}".
 *
 * The followings are the available columns in table '{{voucher_new}}':
 * @property integer $voucher_id
 * @property string $voucher_owner
 * @property integer $merchant_id
 * @property string $joining_merchant
 * @property string $voucher_name
 * @property string $voucher_type
 * @property double $amount
 * @property string $expiration
 * @property int $status
 * @property string $date_created
 * @property string $date_modified
 * @property integer $used_once
 */
class Voucher extends ActiveRecord
{
    public $merchant_list;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Voucher the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getTypes()
    {
        return [0 => Yii::t('basicfield', 'fixed amount'), 1 => Yii::t('basicfield', 'percentage')];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'mt_voucher';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['voucher_name', 'voucher_type', 'amount'], 'required', 'on' => 'other'],
            
            [[ 'voucher_type', 'amount'], 'required', 'on' => 'birthday'],
            [['merchant_id', 'used_once', 'status'], 'integer'],
            ['amount', 'integer'],
            [['voucher_owner', 'voucher_name', 'voucher_type'], 'string', 'max' => 255],
            [['merchant_list', 'expiration','service_id', 'apply_all_services','type'], 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('voucher_id, voucher_owner, merchant_id, joining_merchant, voucher_name, voucher_type, amount, expiration, status, date_created, date_modified, ip_address, used_once', 'safe', 'on' => 'search'),
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
        );
    }
    
    public function getMerchant(){
        return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id' ]);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'voucher_id' => Yii::t('basicfield', 'Coupon'),
            'voucher_owner' => Yii::t('basicfield', 'Coupon Owner'),
            'merchant_id' => Yii::t('basicfield', 'Merchant'),
            'joining_merchant' => Yii::t('basicfield', 'Joining Merchant'),
            'voucher_name' => Yii::t('basicfield', 'Coupon Name'),
            'voucher_type' => Yii::t('basicfield', 'Coupon Type'),
            'amount' => Yii::t('basicfield', 'Amount'),
            'expiration' => Yii::t('basicfield', 'Expiration'),
            'status' => Yii::t('basicfield', 'Is Active'),
            'date_created' => Yii::t('basicfield', 'Date Created'),
            'date_modified' => Yii::t('basicfield', 'Date Modified'),
            'used_once' => Yii::t('basicfield', 'Used Once'),
            'service_id' => Yii::t('basicfield', 'Service'),
            'apply_all_services' => Yii::t('basicfield', 'Apply All Services')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('voucher_id', $this->voucher_id);
        $criteria->compare('voucher_owner', $this->voucher_owner, true);
        $criteria->compare('merchant_id', $this->merchant_id);
        $criteria->compare('joining_merchant', $this->joining_merchant, true);
        $criteria->compare('voucher_name', $this->voucher_name, true);
        $criteria->compare('voucher_type', $this->voucher_type, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('expiration', $this->expiration, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('used_once', $this->used_once);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchMerchant()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('voucher_id', $this->voucher_id);
        $criteria->compare('voucher_owner', $this->voucher_owner, true);
        $criteria->compare('merchant_id', $this->merchant_id);
        $criteria->compare('joining_merchant', $this->joining_merchant, true);
        $criteria->compare('voucher_name', $this->voucher_name, true);
        $criteria->compare('voucher_type', $this->voucher_type, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('expiration', $this->expiration, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('used_once', $this->used_once);

        $criteria->addCondition('merchant_id = ' . Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getVoucherTypeName()
    {
        return self::getTypes()[$this->voucher_type];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            
            if (!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if ($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            if ($this->service_id) $this->service_id = json_encode($this->service_id);
            if ($this->merchant_list) $this->joining_merchant = json_encode($this->merchant_list);
            
            else $this->joining_merchant = json_encode([]);
			
			if(!empty($this->expiration)) $this->expiration = date("Y-m-d", strtotime($this->expiration));
            if(!empty($this->date_created)) $this->date_created = date("Y-m-d", strtotime($this->date_created));
            
            return true;
        } else
            return false;
    }

	public function afterFind()
	{
		$dateFormat = \common\components\Helper::showDateFormat($this->merchant);
		$timeFormat = \common\components\Helper::showTimeFormat($this->merchant);
		
		if(!empty($this->expiration))$this->expiration = date("$dateFormat", strtotime($this->expiration));
		
		if(!empty($this->date_created))$this->date_modified = date("$dateFormat $timeFormat", strtotime($this->date_modified));
		if(!empty($this->date_created))$this->date_created = date("$dateFormat $timeFormat", strtotime($this->date_created));
		//$this->amount = Yii::app()->format->number($this->amount);

		parent::afterFind();
	}

    public function beforeValidate()
    {
        $this->amount = Yii::$app->format->unformatNumber($this->amount);

        return parent::beforeValidate();
    }
}
