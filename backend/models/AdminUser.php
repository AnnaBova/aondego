<?php
namespace backend\models;

use CActiveDataProvider;
use CDbCriteria;
use CPasswordHelper;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

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
class AdminUser extends ActiveRecord implements IdentityInterface
{
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $new_password;
    public $new_password_repeat;
    public $user_permit;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_admin_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['username',  'first_name', 'last_name',  'email_address'], 'required'],
                        ['username','unique'],
                        ['email_address','unique'],
                         [['new_password', 'new_password_repeat'], 'required','on'=>'create'],
			[['user_lang', 'is_active'], 'integer'],
			[['username', 'first_name', 'last_name', 'email_address', 'lost_password_code', 'session_token'], 'string', 'max'=>255],
			[['password', 'role'], 'string', 'max'=>100],
			['ip_address', 'string', 'max'=>50],
                        ['new_password', 'string', 'min'=>6, 'max'=>64, 'on'=>'register, recover'],
                        ['new_password', 'compare','compareAttribute'=>'new_password_repeat','on'=>'create'],
                        ['new_password', 'compare','compareAttribute'=>'new_password_repeat','on'=>'update'],
                        [['new_password_repeat', 'user_permit'], 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
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
	


    public function beforeSave($insert){
       if(parent::beforeSave($insert)){

           
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
    
    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    
    
    
    public static function findIdentity($id)
    {
        return static::findOne(['admin_id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
