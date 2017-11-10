<?php
namespace common\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{merchant_cc}}".
 *
 * The followings are the available columns in table '{{merchant_cc}}':
 * @property integer $mt_id
 * @property integer $merchant_id
 * @property string $card_name
 * @property string $credit_card_number
 * @property string $expiration_month
 * @property string $expiration_yr
 * @property string $cvv
 * @property string $billing_address
 * @property string $date_created
 * @property string $ip_address
 */
class MerchantCc extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{merchant_cc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['merchant_id', 'card_name', 'credit_card_number', 'expiration_month', 'expiration_yr', 'cvv', 'billing_address', 'date_created', 'ip_address'], 'required'],
			['merchant_id','integer'],
			[['card_name', 'billing_address'], 'string', 'max'=>255],
			[['credit_card_number', 'cvv'], 'string', 'max'=>20],
			[['expiration_month', 'expiration_yr'], 'string', 'max'=>5],
			['ip_address', 'string', 'max'=>50],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('mt_id, merchant_id, card_name, credit_card_number, expiration_month, expiration_yr, cvv, billing_address, date_created, ip_address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mt_id' => 'Mt',
			'merchant_id' => 'Merchant',
			'card_name' => 'Card Name',
			'credit_card_number' => 'Credit Card Number',
			'expiration_month' => 'Expiration Month',
			'expiration_yr' => 'Expiration Yr',
			'cvv' => 'Cvv',
			'billing_address' => 'Billing Address',
			'date_created' => 'Date Created',
			'ip_address' => 'Ip Address',
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

		$criteria=new CDbCriteria;

		$criteria->compare('mt_id',$this->mt_id);
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('card_name',$this->card_name,true);
		$criteria->compare('credit_card_number',$this->credit_card_number,true);
		$criteria->compare('expiration_month',$this->expiration_month,true);
		$criteria->compare('expiration_yr',$this->expiration_yr,true);
		$criteria->compare('cvv',$this->cvv,true);
		$criteria->compare('billing_address',$this->billing_address,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MerchantCc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
