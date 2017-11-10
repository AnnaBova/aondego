<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class BillingAddress extends Model
{
    public $street;
    public $client_id;
    public $city;
    public $state;
    public $zipcode;
    public $location_name;
    public $first_name;
    public $last_name;
    public $as_default,$notevoucher, $country_code;
    

    /**
     * @inheritdoc
     */
	public function rules()
	{
	    return [
		[['city',  'zipcode', 'street',
                'first_name', 'last_name', 'notevoucher'], 'required'],

		

		[['client_id', 'as_default'], 'integer'],
		[['date_created', 'date_modified', 'ip_address', 'first_name', 'last_name', 'notevoucher'], 'safe'],
		[['street', 'city', 'state', 'zipcode', 'location_name'], 'string', 'max' => 255],
		[['country_code'], 'string', 'max' => 3],
		
	    ];
	}
    
    
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'client_id' => 'Client ID',
			'street' => Yii::t('basicfield','Street'),
			'city' => Yii::t('basicfield','City'),
			'state' => Yii::t('basicfield','State'),
			'zipcode' => Yii::t('basicfield','Zipcode'),
			'location_name' => Yii::t('basicfield','Full Address'),
			'country_code' => Yii::t('basicfield','Country Code'),
			'as_default' => Yii::t('basicfield','As Default'),
			'date_created' => Yii::t('basicfield','Date Created'),
			'date_modified' => Yii::t('basicfield','Date Modified'),
			'ip_address' => Yii::t('basicfield','Ip Address'),
			'notevoucher' => Yii::t('basicfield','Note on the voucher'),
			'first_name' => Yii::t('basicfield','First Name'),
			'last_name' => Yii::t('basicfield','Last Name')
		];
	}
}