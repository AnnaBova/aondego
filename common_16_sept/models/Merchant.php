<?php

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
class Merchant extends CActiveRecord
{

    const UPLOAD_DIR = 'merchant';
    const UPLOAD_DIR_MAIN = 'merchant/main';

    public $image;
    public $image_big;

    public $is_ready_old = true;

    public $new_password;
    public $new_password_repeat;
    public $manager_new_password;
    public $manager_new_password_repeat;



    public $oneMany = [];
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{merchant}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_name, service_phone, contact_name, contact_phone, contact_email, street, city, state, post_code, package_id', 'required', 'on'=>'edit, create'),
            ['username, new_password, new_password_repeat', 'required','on'=>'create'],
            array('new_password', 'length', 'min'=>6, 'max'=>64),
            array('new_password', 'compare', 'compareAttribute'=>'new_password_repeat','on'=>'create, update'),
            array('manager_new_password', 'length', 'min'=>6, 'max'=>64),
            array('gmap_altitude, gmap_latitude', 'length', 'max'=>30),
            array('address', 'length', 'max'=>510),
            array('manager_new_password', 'compare','on'=>'create, update'),
            array('free_delivery, package_id, payment_steps,is_purchase, is_featured, is_ready, is_sponsored, user_lang, sort_featured, is_commission, status, manager_extended', 'numerical', 'integerOnly'=>true),
			array('package_price, percent_commission, fixed_commission', 'numerical'),
			array('url, service_name, contact_name, contact_email, city, state, service, activation_token, session_token, fb, tw, gl, yt, it, vk, pr, paypall_id, paypall_pass', 'length', 'max'=>255),
            ['contact_email, username, manager_username', 'email'],
			array('service_phone, contact_phone, post_code, delivery_estimation, username, password, manager_username, manager_password', 'length', 'max'=>100),
			array('country_code', 'length', 'max'=>3),
            array('image', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
            array('image_big', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
            ['oneMany, new_password_repeat, manager_new_password_repeat, description','safe'],
			array('activation_key, ip_address, lost_password_code, commission_type', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('merchant_id, service_name, service_phone, contact_name, contact_phone, contact_email, country_code, street, city, state, post_code, cuisine, service, free_delivery, delivery_estimation, username, password, activation_key, activation_token, status, date_created, date_modified, date_activated, last_login, ip_address, package_id, package_price, membership_expired, payment_steps, is_featured, is_ready, is_sponsored, sponsored_expiration, lost_password_code, user_lang, membership_purchase_date, sort_featured, is_commission, percent_commission, abn, session_token, commission_type', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => 'ImageBehavior',
                'imagePath' => self::UPLOAD_DIR,
            ),
            'imageBehavior2' => array(
                'class' => 'ImageBehavior',
                'imagePath' => self::UPLOAD_DIR_MAIN,
                'imageField' => 'image_big'

            ),
            'galleryBehavior' => array(
                'class' => 'GalleryBehavior',
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
                'class' => 'OneManyBehavior',
                'fields'=> [['attr'=>'schedule_days_template_id','label'=>'Schedule Days Template','type'=>'dropDown','data'=>CHtml::listData(ScheduleDaysTemplate::model()->findAll('merchant_id = '.(Yii::app()->user->isGuest?0:Yii::app()->user->id)),'id','title')],
                    ['attr'=>'reason','label'=>'Reason','type'=>'textInput'],['attr'=>'work_date','label'=>'Date','type'=>'date']],
                'relation' => 'futureMerchantSchedules',
                'relationModel' => 'MerchantSchedule',
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'image' => Yii::t('default','Company Logo'),
            'image_big' => Yii::t('default','Main Photo'),
			'merchant_id' => Yii::t('default','Merchant'),
			'service_name' => Yii::t('default','Merchant Company Name'),
			'service_phone' => Yii::t('default','Merchant  Phone'),
			'contact_name' => Yii::t('default','Contact Name'),
			'contact_phone' => Yii::t('default','Contact Phone'),
			'contact_email' => Yii::t('default','Contact Email'),
			'country_code' => Yii::t('default','Country Code'),
			'street' => Yii::t('default','Street'),
			'city' => Yii::t('default','City'),
			'state' => Yii::t('default','State'),
			'post_code' => Yii::t('default','Post Code'),
			'cuisine' => Yii::t('default','Cuisine'),
			'service' => Yii::t('default','Service'),
			'free_delivery' => Yii::t('default','Free Delivery'),
			'delivery_estimation' => Yii::t('default','Delivery Estimation'),
			'username' => Yii::t('default','Merchant Admin Email'),
            'manager_username' => Yii::t('default','Merchant Manager Email'),
			'password' => Yii::t('default','Password'),
			'activation_key' => Yii::t('default','Activation Key'),
			'activation_token' => Yii::t('default','Activation Token'),
			'status' => Yii::t('default','Is Active'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Updated'),
			'date_activated' => Yii::t('default','Date Activated'),
			'last_login' => Yii::t('default','Last Login'),
			'ip_address' => Yii::t('default','Ip Address'),
			'package_id' => Yii::t('default','Package'),
			'package_price' => Yii::t('default','Package Price'),
			'membership_expired' => Yii::t('default','Membership Expired'),
			'payment_steps' => Yii::t('default','Payment Steps'),
			'is_featured' => Yii::t('default','Is Featured'),
			'is_ready' => Yii::t('default','Is Ready'),
			'is_sponsored' => Yii::t('default','Is Sponsored'),
			'sponsored_expiration' => Yii::t('default','Sponsored Expiration'),
			'lost_password_code' => Yii::t('default','Lost Password Code'),
			'user_lang' => Yii::t('default','User Lang'),
			'membership_purchase_date' => Yii::t('default','Membership Purchase Date'),
			'sort_featured' => Yii::t('default','Sort Featured'),
			'is_commission' => Yii::t('default','Is Commission'),
			'percent_commission' => Yii::t('default','Percent Commission'),
			'fixed_commission' => Yii::t('default','Fixed Commission'),
			'session_token' => Yii::t('default','Session Token'),
			'commission_type' => Yii::t('default','Commission Type'),
            //'subcategory_id' => 'Category',
            'new_password' => Yii::t('default','New Password'),
            'new_password_repeat' => Yii::t('default','Confirm Password'),
            'manager_new_password' => Yii::t('default','Manager New Password'),
            'manager_new_password_repeat' => Yii::t('default','Manager Confirm Password'),
            'manager_extended'=> Yii::t('default','Extended Manager'),
            'fb'=>'Facebook', 'tw'=>'Twitter', 'gl'=>'Google', 'yt'=>'Youtube', 'it'=>'Instagram',
            'paypall_id' => 'PayPall ID',
            'paypall_pass'=>'PayPall Pass',
            'gmap_altitude' => Yii::t('default','Altitude'),
            'gmap_latitude' => Yii::t('default','Latitude'),
            'address' => Yii::t('default','Address'),
            'vk' => 'Vkontakte',
            'pr'=> 'Pinterest',
            'is_purchase'=> Yii::t('default','Is Purchase'),
            'description'=>Yii::t('default','Description'),

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

		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('service_phone',$this->service_phone,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_phone',$this->contact_phone,true);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('post_code',$this->post_code,true);
		$criteria->compare('cuisine',$this->cuisine,true);
		$criteria->compare('service',$this->service);
		$criteria->compare('free_delivery',$this->free_delivery);
		$criteria->compare('delivery_estimation',$this->delivery_estimation,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('activation_key',$this->activation_key,true);
		$criteria->compare('activation_token',$this->activation_token,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('date_activated',$this->date_activated,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('package_price',$this->package_price);
		$criteria->compare('membership_expired',$this->membership_expired,true);
		$criteria->compare('payment_steps',$this->payment_steps);
		$criteria->compare('is_featured',$this->is_featured);
		$criteria->compare('is_ready',$this->is_ready);
        $criteria->compare('is_purchase',$this->is_ready);
		$criteria->compare('is_sponsored',$this->is_sponsored);
		$criteria->compare('sponsored_expiration',$this->sponsored_expiration,true);
		$criteria->compare('lost_password_code',$this->lost_password_code,true);
		$criteria->compare('user_lang',$this->user_lang);
		$criteria->compare('membership_purchase_date',$this->membership_purchase_date,true);
		$criteria->compare('sort_featured',$this->sort_featured);
		$criteria->compare('is_commission',$this->is_commission);
		$criteria->compare('percent_commission',$this->percent_commission);
		$criteria->compare('fixed_commission',$this->fixed_commission,true);
		$criteria->compare('session_token',$this->session_token,true);
		$criteria->compare('commission_type',$this->commission_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Merchant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function beforeSave(){
        if(parent::beforeSave()){
            if(empty($this->url)) $this->url = UrlHelper::getSlugFromString($this->service_name);
            if($this->new_password) $this->password = $this->hashPassword($this->new_password);
            if($this->manager_new_password) $this->manager_password = $this->hashPassword($this->manager_new_password);

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
    public function validatePassword($password,$role)
    {//d($this->hashPassword('restomulti'));
        return CPasswordHelper::verifyPassword($password,$role?$this->password:$this->manager_password);
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

    public function afterFind() {
        $this->package_price = Yii::app()->format->number($this->package_price);
        $this->percent_commission = Yii::app()->format->number($this->percent_commission);
        $this->fixed_commission = Yii::app()->format->number($this->fixed_commission);
         parent::afterFind();
    }

    public function beforeValidate() {
        $this->package_price = Yii::app()->format->unformatNumber($this->package_price);
        $this->percent_commission = Yii::app()->format->unformatNumber($this->percent_commission);
        $this->fixed_commission = Yii::app()->format->unformatNumber($this->fixed_commission);
        return parent::beforeValidate();
    }
}
