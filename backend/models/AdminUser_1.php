<?php

/**
 * This is the model class for table "{{admin_user}}".
 *
 * The followings are the available columns in table '{{admin_user}}':
 * @property integer $admin_id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 * @property integer $user_lang
 * @property string $email_address
 * @property string $lost_password_code
 * @property string $session_token
 * @property string $last_login
 * @property string $user_access
 */
class AdminUser extends CActiveRecord
{

    public $new_password;
    public $new_password_repeat;
    public $user_permit;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{admin_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username,  first_name, last_name,  email_address', 'required'),
            ['username','unique'],
            ['email_address','unique'],
            ['new_password, new_password_repeat', 'required','on'=>'create'],
			array('user_lang, is_active', 'numerical', 'integerOnly'=>true),
			array('username, first_name, last_name, email_address, lost_password_code, session_token', 'length', 'max'=>255),
			array('password, role', 'length', 'max'=>100),
			array('ip_address', 'length', 'max'=>50),
            array('new_password', 'length', 'min'=>6, 'max'=>64, 'on'=>'register, recover'),
            array('new_password', 'compare','on'=>'create, update'),
            array('new_password_repeat, user_permit', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('admin_id, username, password, first_name, last_name, role, date_created, date_modified, ip_address, user_lang, email_address, lost_password_code, session_token, last_login, user_access', 'safe', 'on'=>'search'),
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
			'admin_id' => 'Admin',
			'username' => 'Username',
			'password' => 'Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'role' => 'Role',
			'date_created' => 'Date Created',
			'date_modified' => 'Date Modified',
			'ip_address' => 'Ip Address',
			'user_lang' => 'User Lang',
			'email_address' => 'Email Address',
			'lost_password_code' => 'Lost Password Code',
			'session_token' => 'Session Token',
			'last_login' => 'Last Login',
			'user_access' => 'User Access',
            'fullName' => 'Full Name',
            'new_password' => 'New Password',
            'new_password_repeat' => 'Confirm Password',
            'is_active' => 'Is Active'
		);
	}

    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
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

		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('username',$this->username,true);

		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('email_address',$this->email_address,true);

		$criteria->compare('last_login',$this->last_login,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function beforeSave(){
       if(parent::beforeSave()){

           if($this->new_password) $this->password = $this->hashPassword($this->new_password);
           if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
           if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");

           if($this->user_permit) $this->user_access = json_encode($this->user_permit);
           return true;
       } else
        return false;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdminUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getAccess()
    {

        return json_decode($this->user_access);
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {//d($this->hashPassword('restomulti'));
        return CPasswordHelper::verifyPassword($password,$this->password);
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public function hashPassword($password)
    {
        return CPasswordHelper::hashPassword($password);
    }
}
