<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property integer $client_id
 * @property string $social_strategy
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $password
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country_code
 * @property string $location_name
 * @property string $contact_phone
 * @property string $lost_password_token
 * @property string $date_created
 * @property string $date_modified
 * @property string $last_login
 * @property string $ip_address
 * @property string $status
 * @property string $token
 * @property integer $mobile_verification_code
 * @property string $mobile_verification_date
 * @property string $custom_field1
 * @property string $custom_field2
 */
class Client extends ActiveRecord
{
	public $fullName;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['first_name',  'email_address', 'contact_phone', 'dob'], 'required'],
			[['mobile_verification_code', 'status'], 'integer'],
			[['social_strategy', 'password', 'zipcode'], 'string', 'max'=>100],
			[['first_name', 'last_name', 'street', 'city', 'state', 'lost_password_token', 'token', 'custom_field1', 'custom_field2'], 'string', 'max'=>255],
			['email_address', 'string', 'max'=>200],
                        ['email_address', 'email'],
			['email_address', 'unique'],
			['country_code', 'string', 'max'=>3],
			['contact_phone', 'string', 'max'=>20],
			['ip_address', 'string', 'max'=>50],
                    [['dob'], 'safe']
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['client_id, social_strategy, first_name, last_name, email_address, password, street, city, state, zipcode, country_code, location_name, contact_phone, lost_password_token, date_created, date_modified, last_login, ip_address, status, token, mobile_verification_code, mobile_verification_date, custom_field1, custom_field2', 'safe', 'on'=>'search'),
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
			'client_id' => Yii::t('basicfield','Client'),
			'social_strategy' => Yii::t('basicfield','Social Strategy'),
			'first_name' => Yii::t('basicfield','First Name'),
			'last_name' => Yii::t('basicfield','Last Name'),
			'email_address' => Yii::t('basicfield','Email Address'),
			'password' => Yii::t('basicfield','Password'),
			'street' => Yii::t('basicfield','Street'),
			'city' => Yii::t('basicfield','City'),
			'state' => Yii::t('basicfield','State'),
			'zipcode' => Yii::t('basicfield','Zipcode'),
			'country_code' => Yii::t('basicfield','Country Code'),
			'location_name' => Yii::t('basicfield','Location Name'),
			'contact_phone' => Yii::t('basicfield','Contact Phone'),
			'lost_password_token' => Yii::t('basicfield','Lost Password Token'),
			'date_created' => Yii::t('basicfield','Date Created'),
			'date_modified' => Yii::t('basicfield','Date Modified'),
			'last_login' => Yii::t('basicfield','Last Login'),
			'ip_address' => Yii::t('basicfield','Ip Address'),
			'status' => Yii::t('basicfield','Is Active'),
			'token' => Yii::t('basicfield','Token'),
			'mobile_verification_code' => Yii::t('basicfield','Mobile Verification Code'),
			'mobile_verification_date' => Yii::t('basicfield','Mobile Verification Date'),
			'custom_field1' => Yii::t('basicfield','Custom Field One'),
			'custom_field2' => Yii::t('basicfield','Custom Field Two'),
			'dob' => Yii::t('basicfield' , 'Date of Birth')
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

		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('social_strategy',$this->social_strategy,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('location_name',$this->location_name,true);
		$criteria->compare('contact_phone',$this->contact_phone,true);
		$criteria->compare('lost_password_token',$this->lost_password_token,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('mobile_verification_code',$this->mobile_verification_code);
		$criteria->compare('mobile_verification_date',$this->mobile_verification_date,true);
		$criteria->compare('custom_field1',$this->custom_field1,true);
		$criteria->compare('custom_field2',$this->custom_field2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            if(!empty($this->dob)) $this->dob = date('Y-m-d', strtotime($this->dob));
            return true;
        } else
            return false;
    }
    
    public function afterFind(){
        $this->date_modified = date('d-m-Y H:i:s', strtotime($this->date_modified));
        if(!empty($this->date_created))$this->date_created = date('d-m-Y H:i:s', strtotime($this->date_created));
        if(!empty($this->last_login))$this->last_login = date('d-m-Y H:i:s', strtotime($this->last_login));
        $this->dob = date('d-m-Y', strtotime($this->dob));
        parent::afterFind();
    }
    
    
    public function getfullName(){
	    return $this->first_name.' '.$this->last_name;
    }
}
