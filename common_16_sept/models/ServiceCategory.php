<?php

/**
 * This is the model class for table "{{service_category}}".
 *
 * The followings are the available columns in table '{{service_category}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $is_active
 * @property integer $is_approved
 * @property string $approved_text
 * @property string $date_created
 * @property string $date_updated
 * @property integer $merchant_id
 *
 * The followings are the available model relations:
 * @property ServiceSubcategory[] $serviceSubcategories
 */
class ServiceCategory extends CActiveRecord
{

    const UPLOAD_DIR = 'category';
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, url', 'required'),
			array('is_active, is_approved, merchant_id', 'numerical', 'integerOnly'=>true),
			array('title, url', 'length', 'max'=>255),
			array('approved_text', 'length', 'max'=>500),
			array('description, date_updated', 'safe'),

            array('image', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, is_active, is_approved, approved_text, date_created, date_updated, merchant_id', 'safe', 'on'=>'search'),
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
			'serviceSubcategories' => array(self::HAS_MANY, 'ServiceSubcategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('default','Title'),
			'description' => Yii::t('default','Description'),
			'is_active' => Yii::t('default','Is Active'),
			'is_approved' => Yii::t('default','Is Approved'),
			'approved_text' => Yii::t('default','Approved Text'),
			'date_created' => Yii::t('default','Date Created'),
			'date_updated' => Yii::t('default','Date Updated'),
			'merchant_id' => Yii::t('default','Merchant'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('approved_text',$this->approved_text,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('merchant_id',$this->merchant_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if(parent::beforeSave()){
            if(!$this->isNewRecord) $this->date_updated = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }
}
