<?php
namespace common\models;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{merchant_user}}".
 *
 * The followings are the available columns in table '{{merchant_user}}':
 * @property integer $merchant_user_id
 * @property integer $merchant_id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $user_access
 * @property string $date_created
 * @property string $date_modified
 * @property string $status
 * @property string $last_login
 * @property string $ip_address
 * @property string $contact_email
 * @property string $session_token
 */
class MerchantUser extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{merchant_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['merchant_id', 'first_name', 'last_name', 'username', 'password', 'user_access', 'date_created', 'date_modified', 'last_login', 'ip_address', 'contact_email', 'session_token'], 'required'],
			['merchant_id','integer'],
			[['first_name', 'last_name', 'username', 'password', 'contact_email', 'session_token'], 'string', 'max'=>255],
			['status', 'string', 'max'=>100],
			['ip_address', 'string', 'max'=>50],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('merchant_user_id, merchant_id, first_name, last_name, username, password, user_access, date_created, date_modified, status, last_login, ip_address, contact_email, session_token', 'safe', 'on'=>'search'),
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
			'merchant_user_id' => Yii::t('basicfield','Merchant User'),
			'merchant_id' => Yii::t('basicfield','Merchant'),
			'first_name' => Yii::t('basicfield','First Name'),
			'last_name' => Yii::t('basicfield','Last Name'),
			'username' => Yii::t('basicfield','Username'),
			'password' => Yii::t('basicfield','Password'),
			'user_access' => Yii::t('basicfield','User Access'),
			'date_created' => Yii::t('basicfield','Date Created'),
			'date_modified' => Yii::t('basicfield','Date Modified'),
			'status' => Yii::t('basicfield','Status'),
			'last_login' => Yii::t('basicfield','Last Login'),
			'ip_address' => Yii::t('basicfield','Ip Address'),
			'contact_email' => Yii::t('basicfield','Contact Email'),
			'session_token' => Yii::t('basicfield','Session Token'),
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

		$criteria->compare('merchant_user_id',$this->merchant_user_id);
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_access',$this->user_access,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('session_token',$this->session_token,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MerchantUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
