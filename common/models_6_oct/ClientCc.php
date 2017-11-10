<?php
namespace common\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{client_cc}}".
 *
 * The followings are the available columns in table '{{client_cc}}':
 * @property integer $cc_id
 * @property integer $client_id
 * @property string $card_name
 * @property string $credit_card_number
 * @property string $expiration_month
 * @property string $expiration_yr
 * @property string $cvv
 * @property string $billing_address
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 */
class ClientCc extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{client_cc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['client_id', 'card_name', 'credit_card_number', 'expiration_month', 'expiration_yr', 'cvv', 'billing_address', 'date_created', 'date_modified', 'ip_address'], 'required'],
			['client_id','integer'],
			[['card_name', 'billing_address'], 'string', 'max'=>255],
			[['credit_card_number', 'cvv'], 'string', 'max'=>20],
			[['expiration_month', 'expiration_yr'], 'string', 'max'=>5],
			['ip_address', 'string', 'max'=>50],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('cc_id, client_id, card_name, credit_card_number, expiration_month, expiration_yr, cvv, billing_address, date_created, date_modified, ip_address', 'safe', 'on'=>'search'),
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
			'cc_id' => 'Cc',
			'client_id' => Yii::t('default','Client'),
			'card_name' => Yii::t('default','Card Name'),
			'credit_card_number' => Yii::t('default','Credit Card Number'),
			'expiration_month' => Yii::t('default','Expiration Month'),
			'expiration_yr' => Yii::t('default','Expiration Yr'),
			'cvv' => Yii::t('default','Cvv'),
			'billing_address' => Yii::t('default','Billing Address'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Modified'),
			'ip_address' => Yii::t('default','Ip Address'),
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

		$criteria->compare('cc_id',$this->cc_id);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('card_name',$this->card_name,true);
		$criteria->compare('credit_card_number',$this->credit_card_number,true);
		$criteria->compare('expiration_month',$this->expiration_month,true);
		$criteria->compare('expiration_yr',$this->expiration_yr,true);
		$criteria->compare('cvv',$this->cvv,true);
		$criteria->compare('billing_address',$this->billing_address,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientCc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
