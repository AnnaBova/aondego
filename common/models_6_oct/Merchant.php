<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{merchant}}".
 *
 * The followings are the available columns in table '{{merchant}}':
 * @property integer $merchant_id
 * @property string $service_name
 * @property string $service_phone
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $country_code
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $post_code
 * @property string $cuisine
 * @property string $service
 * @property integer $free_delivery
 * @property string $delivery_estimation
 * @property string $username
 * @property string $password
 * @property string $activation_key
 * @property string $activation_token
 * @property string $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $date_activated
 * @property string $last_login
 * @property string $ip_address
 * @property integer $package_id
 * @property double $package_price
 * @property string $membership_expired
 * @property integer $payment_steps
 * @property integer $is_featured
 * @property integer $is_ready
 * @property integer $is_sponsored
 * @property string $sponsored_expiration
 * @property string $lost_password_code
 * @property integer $user_lang
 * @property string $membership_purchase_date
 * @property integer $sort_featured
 * @property integer $is_commission
 * @property double $percent_commission
 * @property string $fixed_commission
 * @property string $session_token
 * @property string $commission_type
 * @property string $manager_password
 * @property string $manager_username
 * @property string $is_purchase
 * @property Packages $package
 */
class Merchant extends ActiveRecord implements IdentityInterface
{
    
    public static function primaryKey(){
        return ['merchant_id'];
    }

    const UPLOAD_DIR = 'merchant';
    const UPLOAD_DIR_MAIN = 'merchant/main';
    const STATUS_ACTIVE = 1;

    public $image;
    public $image_big;

    public $is_ready_old = true;

    public $new_password;
    public $new_password_repeat;
    public $manager_new_password;
    public $manager_new_password_repeat;
    public $role = 0;



    public $oneMany = [];
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_merchant';
	}
        
        public function __construct()
        {
            $session = Yii::$app->session;
            if($session['role']){
                $this->role = $session['role'];
            }
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['service_name', 'service_phone', 'contact_name', 'contact_phone', 'contact_email', 'street', 'city', 'state', 'post_code', 'package_id'], 'required', 'on'=>'edit, create'],
            [['username', 'new_password', 'new_password_repeat'], 'required','on'=>'create'],
            [['new_password'],'string', 'length'=>[6, 64]],
            ['new_password', 'compare', 'compareAttribute'=>'new_password_repeat','on'=>'create'],
                    ['new_password', 'compare', 'compareAttribute'=>'new_password_repeat','on'=>'edit'],
            [['manager_new_password'],'string', 'length'=>[6, 64]],
            [['gmap_altitude', 'gmap_latitude'], 'string', 'max'=>30],
            ['address', 'string', 'max'=>510],
            [['manager_new_password'], 'compare','compareAttribute'=>'manager_new_password_repeat','on'=>'edit'],
            [['free_delivery', 'package_id', 'payment_steps','is_purchase', 'is_featured', 'is_ready', 'is_sponsored', 'user_lang', 'sort_featured', 'is_commission', 'status', 'manager_extended'], 'integer', 'integerOnly'=>true],
			[['package_price', 'percent_commission', 'fixed_commission'], 'integer'],
			[['url', 'service_name', 'contact_name', 'contact_email', 'city', 'state', 'service', 'activation_token', 'session_token', 'fb', 'tw', 'gl', 'yt', 'it', 'vk', 'pr', 'paypall_id', 'paypall_pass'], 'string', 'max'=>255],
            [['contact_email', 'username', 'manager_username'], 'email'],
			[['service_phone', 'contact_phone', 'post_code', 'delivery_estimation', 'username', 'password', 'manager_username', 'manager_password'], 'string', 'max'=>100],
			['country_code', 'string', 'max'=>3],
            ['image', 'image', 'extensions'=>'jpg, png'],
            ['image_big', 'image', 'extensions'=>'jpg, png'],
            [['oneMany', 'new_password_repeat', 'manager_new_password_repeat', 'description'],'safe'],
			[['activation_key', 'ip_address', 'lost_password_code'], 'string', 'max'=>50],
			
                    [['manager_password_hash', 'manager_password_reset_token', 'commission_type'], 'safe']
                // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('merchant_id, service_name, service_phone, contact_name, contact_phone, contact_email, country_code, street, city, state, post_code, cuisine, service, free_delivery, delivery_estimation, username, password, activation_key, activation_token, status, date_created, date_modified, date_activated, last_login, ip_address, package_id, package_price, membership_expired, payment_steps, is_featured, is_ready, is_sponsored, sponsored_expiration, lost_password_code, user_lang, membership_purchase_date, sort_featured, is_commission, percent_commission, abn, session_token, commission_type', 'safe', 'on'=>'search'),
		];
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => \frontend\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ),
            'imageBehavior2' => array(
                'class' => \frontend\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR_MAIN,
                'imageField' => 'image_big'

            ),
            'galleryBehavior' => array(
                'class' => \common\extensions\gallerymanager\GalleryBehavior::className(),
                'idAttribute' => 'gallery_id',
                'versions' => array(
                    'small' => array(
                        'centeredpreview' => array(98, 98),
                    ),
                    'medium' => array(
                        'resize' => array(800, null),
                    )
                ),
                'name' => true,
                'description' => true,
            ),
            'oneManyBehavior' => array(
                'class' => \common\extensions\OneManyBehavior::className(),
                'fields'=> [
                    ['attr'=>'schedule_days_template_id',
                        'label'=>'Schedule Days Template',
                        'type'=>'dropDown',
                        'data'=>\yii\helpers\ArrayHelper::map(ScheduleDaysTemplate::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','title')],
                    ['attr'=>'reason','label'=>'Reason','type'=>'textInput'],['attr'=>'work_date','label'=>'Date','type'=>'date']],
                'relation' => 'futureMerchantSchedules',
                'relationModel' => '\common\models\MerchantSchedule',
                'parent_column_name' => 'merchant_id'
            ),
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
            'lastSchedule' => array(self::HAS_ONE, 'MerchantScheduleHistory', 'merchant_id','order'=>'id DESC'),
            'schedule' => array(self::HAS_MANY, 'MerchantScheduleHistory', 'merchant_id'),
            'merchantSchedules' => array(self::HAS_MANY, 'MerchantSchedule', 'merchant_id'),
            'futureMerchantSchedules' => array(self::HAS_MANY, 'MerchantSchedule', 'merchant_id','condition'=>'work_date>="'.date('Y-m-d').'"'),
            'package' => array(self::BELONGS_TO, 'Packages', 'package_id'),
         //   'category' => array(self::BELONGS_TO, 'ServiceCategory', 'subcategory_id'),
		);
	}
        
        public function getPackage()
        {
            return $this->hasOne(Packages::className(), ['package_id' => 'package_id']);
        }
        
        public function getLastSchedule()
        {
            return $this->hasOne(MerchantScheduleHistory::className(), ['merchant_id' => 'merchant_id'])->orderBy(['id'=>SORT_DESC]);
        }
        
        public function getFutureMerchantSchedules()
        {
            return $this->hasMany(MerchantSchedule::className(), ['merchant_id' => 'merchant_id'])->where('work_date>="'.date('Y-m-d').'"');
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'image' => Yii::t('app','Company Logo'),
            'image_big' => Yii::t('app','Main Photo'),
			'merchant_id' => Yii::t('app','Merchant'),
			'service_name' => Yii::t('app','Merchant Company Name'),
			'service_phone' => Yii::t('app','Merchant  Phone'),
			'contact_name' => Yii::t('app','Contact Name'),
			'contact_phone' => Yii::t('app','Contact Phone'),
			'contact_email' => Yii::t('app','Contact Email'),
			'country_code' => Yii::t('app','Country Code'),
			'street' => Yii::t('app','Street'),
			'city' => Yii::t('app','City'),
			'state' => Yii::t('app','State'),
			'post_code' => Yii::t('app','Post Code'),
			'cuisine' => Yii::t('app','Cuisine'),
			'service' => Yii::t('app','Service'),
			'free_delivery' => Yii::t('app','Free Delivery'),
			'delivery_estimation' => Yii::t('app','Delivery Estimation'),
			'username' => Yii::t('app','Merchant Admin Email'),
            'manager_username' => Yii::t('app','Merchant Manager Email'),
			'password' => Yii::t('app','Password'),
			'activation_key' => Yii::t('app','Activation Key'),
			'activation_token' => Yii::t('app','Activation Token'),
			'status' => Yii::t('app','Is Active'),
			'date_created' => Yii::t('app','Date Created'),
			'date_modified' => Yii::t('app','Date Updated'),
			'date_activated' => Yii::t('app','Date Activated'),
			'last_login' => Yii::t('app','Last Login'),
			'ip_address' => Yii::t('app','Ip Address'),
			'package_id' => Yii::t('app','Package'),
			'package_price' => Yii::t('app','Package Price'),
			'membership_expired' => Yii::t('app','Membership Expired'),
			'payment_steps' => Yii::t('app','Payment Steps'),
			'is_featured' => Yii::t('app','Is Featured'),
			'is_ready' => Yii::t('app','Is Ready'),
			'is_sponsored' => Yii::t('app','Is Sponsored'),
			'sponsored_expiration' => Yii::t('app','Sponsored Expiration'),
			'lost_password_code' => Yii::t('app','Lost Password Code'),
			'user_lang' => Yii::t('app','User Lang'),
			'membership_purchase_date' => Yii::t('app','Membership Purchase Date'),
			'sort_featured' => Yii::t('app','Sort Featured'),
			'is_commission' => Yii::t('app','Is Commission'),
			'percent_commission' => Yii::t('app','Percent Commission'),
			'fixed_commission' => Yii::t('app','Fixed Commission'),
			'session_token' => Yii::t('app','Session Token'),
			'commission_type' => Yii::t('app','Commission Type'),
            //'subcategory_id' => 'Category',
            'new_password' => Yii::t('app','New Password'),
            'new_password_repeat' => Yii::t('app','Confirm Password'),
            'manager_new_password' => Yii::t('app','Manager New Password'),
            'manager_new_password_repeat' => Yii::t('app','Manager Confirm Password'),
            'manager_extended'=> Yii::t('app','Extended Manager'),
            'fb'=>'Facebook', 'tw'=>'Twitter', 'gl'=>'Google', 'yt'=>'Youtube', 'it'=>'Instagram',
            'paypall_id' => 'PayPall ID',
            'paypall_pass'=>'PayPall Pass',
            'gmap_altitude' => Yii::t('app','Altitude'),
            'gmap_latitude' => Yii::t('app','Latitude'),
            'address' => Yii::t('app','Address'),
            'vk' => 'Vkontakte',
            'pr'=> 'Pinterest',
            'is_purchase'=> Yii::t('app','Is Purchase'),
            'description'=>Yii::t('app','Description'),

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
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Merchant the static model class
	 */
	


    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(empty($this->url)) $this->url = UrlHelper::getSlugFromString($this->service_name);
            //if($this->new_password) $this->password = $this->hashPassword($this->new_password);
            //if($this->manager_new_password) $this->manager_password = $this->hashPassword($this->manager_new_password);

            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            if(!$this->isNewRecord && $this->is_ready && !$this->is_ready_old){
                $this->date_activated = date("Y-m-d H:i:s");
                if($this->package->expiration_type)
                    $this->membership_expired = date("Y-m-d H:i:s",strtotime('+'.$this->package->expiration.' days'));
                    else

                $this->membership_expired = date("Y-m-d H:i:s",strtotime('+1 year'));

            }
            return true;
        } else
            return false;
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
//    public function hashPassword($password)
//    {
//        return CPasswordHelper::hashPassword($password);
//    }

    public function afterFind() {
//        $this->package_price = Yii::$app->format->number($this->package_price);
//        $this->percent_commission = Yii::$app->format->number($this->percent_commission);
//        $this->fixed_commission = Yii::$app->format->number($this->fixed_commission);
//         parent::afterFind();
    }

    public function beforeValidate() {
        $this->package_price = Yii::$app->format->unformatNumber($this->package_price);
        $this->percent_commission = Yii::$app->format->unformatNumber($this->percent_commission);
        $this->fixed_commission = Yii::$app->format->unformatNumber($this->fixed_commission);
        return parent::beforeValidate();
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['merchant_id' => $id, 'status' => self::STATUS_ACTIVE]);
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
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    
    public static function findByManagerUsername($username)
    {
        return static::findOne(['manager_username' => $username, 'status' => self::STATUS_ACTIVE]);
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
    
    public function validateManagerPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->manager_password_hash);
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
    
    public  function setManagerPassword($password){
        $this->manager_password_hash = Yii::$app->security->generatePasswordHash($password);
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
