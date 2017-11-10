<?php

/**
 * This is the model class for table "{{packages}}".
 *
 * The followings are the available columns in table '{{packages}}':
 * @property integer $package_id
 * @property string $title
 * @property string $description
 * @property double $price
 * @property double $promo_price
 * @property integer $expiration
 * @property string $expiration_type
 * @property integer $unlimited_post
 * @property integer $post_limit
 * @property integer $sequence
 * @property string $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 * @property integer $sell_limit
 */
class Packages extends CActiveRecord
{

    const UPLOAD_DIR = 'package';
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{packages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, price', 'required'),
			array('expiration, expiration_type,workers_limit, unlimited_post, post_limit, sequence, sell_limit, status, commission_type, is_commission', 'numerical', 'integerOnly'=>true),
			array('price, promo_price, fixed_commission, percent_commission', 'numerical'),
			array('title', 'length', 'max'=>255),
            array('image', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('package_id, title, description, price, promo_price, expiration, expiration_type, unlimited_post, post_limit, sequence, status, date_created, date_modified, ip_address, sell_limit', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => 'ImageBehavior',
                'imagePath' => self::UPLOAD_DIR,
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'package_id' => Yii::t('default','ID'),
			'title' => Yii::t('default','Title'),
			'description' => Yii::t('default','Description'),
			'price' => Yii::t('default','Price'),
			'promo_price' => Yii::t('default','Promo Price'),
			'expiration' => Yii::t('default','Expiration Days'),
			'expiration_type' => Yii::t('default','Expiration Type'),
			'unlimited_post' => Yii::t('default','Post Limit Type'),
			'post_limit' => Yii::t('default','Post Limit'),
			'sequence' => Yii::t('default','Sequence'),
			'status' => Yii::t('default','Is Active'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Updated'),
			'sell_limit' => Yii::t('default','Sell Limit'),
            'workers_limit' => Yii::t('default','Workers Limit'),
            'is_commission' => Yii::t('default','Is Commission'),
            'percent_commission' => Yii::t('default','Percent Commission'),
            'fixed_commission' => Yii::t('default','Fixed Commission'),
            'session_token' => Yii::t('default','Session Token'),
            'commission_type' => Yii::t('default','Commission Type'),
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

		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('promo_price',$this->promo_price);
		$criteria->compare('expiration',$this->expiration);
		$criteria->compare('expiration_type',$this->expiration_type);
		$criteria->compare('unlimited_post',$this->unlimited_post);
		$criteria->compare('post_limit',$this->post_limit);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('sell_limit',$this->sell_limit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Packages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getTypes()
    {
        return [0=>'Year',1=>'Days'];
    }

    public static function getLimits()
    {
        return [0=>'Limited',1=>'Unlimited'];
    }

    public function beforeSave(){
        if(parent::beforeSave()){
            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }

    public function afterFind() {
        $this->price = Yii::app()->format->number($this->price);
        $this->promo_price = Yii::app()->format->number($this->promo_price);
        $this->fixed_commission = Yii::app()->format->number($this->fixed_commission);
        $this->percent_commission = Yii::app()->format->number($this->percent_commission);
         parent::afterFind();
    }

    public function beforeValidate() {
        $this->price = Yii::app()->format->unformatNumber($this->price);
        $this->promo_price = Yii::app()->format->unformatNumber($this->promo_price);
        $this->fixed_commission = Yii::app()->format->unformatNumber($this->fixed_commission);
        $this->percent_commission = Yii::app()->format->unformatNumber($this->percent_commission);
        return parent::beforeValidate();
    }
}
