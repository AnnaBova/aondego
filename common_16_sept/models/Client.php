<?php

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
class Client extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email_address, contact_phone', 'required'),
			array('mobile_verification_code, status', 'numerical', 'integerOnly'=>true),
			array('social_strategy, password, zipcode', 'length', 'max'=>100),
			array('first_name, last_name, street, city, state, lost_password_token, token, custom_field1, custom_field2', 'length', 'max'=>255),
			array('email_address', 'length', 'max'=>200),
            array('email_address', 'email'),
			array('country_code', 'length', 'max'=>3),
			array('contact_phone', 'length', 'max'=>20),
			array('ip_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('client_id, social_strategy, first_name, last_name, email_address, password, street, city, state, zipcode, country_code, location_name, contact_phone, lost_password_token, date_created, date_modified, last_login, ip_address, status, token, mobile_verification_code, mobile_verification_date, custom_field1, custom_field2', 'safe', 'on'=>'search'),
		);
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
			'client_id' => Yii::t('default','Client'),
			'social_strategy' => Yii::t('default','Social Strategy'),
			'first_name' => Yii::t('default','First Name'),
			'last_name' => Yii::t('default','Last Name'),
			'email_address' => Yii::t('default','Email Address'),
			'password' => Yii::t('default','Password'),
			'street' => Yii::t('default','Street'),
			'city' => Yii::t('default','City'),
			'state' => Yii::t('default','State'),
			'zipcode' => Yii::t('default','Zipcode'),
			'country_code' => Yii::t('default','Country Code'),
			'location_name' => Yii::t('default','Location Name'),
			'contact_phone' => Yii::t('default','Contact Phone'),
			'lost_password_token' => Yii::t('default','Lost Password Token'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Modified'),
			'last_login' => Yii::t('default','Last Login'),
			'ip_address' => Yii::t('default','Ip Address'),
			'status' => Yii::t('default','Is Active'),
			'token' => Yii::t('default','Token'),
			'mobile_verification_code' => Yii::t('default','Mobile Verification Code'),
			'mobile_verification_date' => Yii::t('default','Mobile Verification Date'),
			'custom_field1' => Yii::t('default','Custom Field One'),
            'custom_field2' => Yii::t('default','Custom Field Two'),
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

    public function beforeSave(){
        if(parent::beforeSave()){
            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }
}
