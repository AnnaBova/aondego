<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
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
class ServiceCategory extends ActiveRecord
{

    const UPLOAD_DIR = 'category';
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_service_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
                    [['title', 'url'], 'required'],
                    [['description'], 'string'],
                    [['is_active', 'is_approved', 'merchant_id'], 'integer'],
                    [['date_created', 'date_updated'], 'safe'],
                    [['title', 'seo_title', 'url', 'seo_description', 'seo_keywords'], 'string', 'max' => 255],
                    [['approved_text'], 'string', 'max' => 500],
                ];
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => \common\extensions\ImageBehavior::className(),
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
			'title' => Yii::t('basicfield','Title'),
			'description' => Yii::t('basicfield','Description'),
			'is_active' => Yii::t('basicfield','Is Active'),
			'is_approved' => Yii::t('basicfield','Is Approved'),
			'approved_text' => Yii::t('basicfield','Approved Text'),
			'date_created' => Yii::t('basicfield','Date Created'),
			'date_updated' => Yii::t('basicfield','Date Updated'),
			'merchant_id' => Yii::t('basicfield','Merchant'),
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
	

	public function beforeSave($insert){
	    if(parent::beforeSave($insert)){
		if(!$this->isNewRecord) $this->date_updated = date("Y-m-d H:i:s");
		if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
		
		if(!empty($this->date_created)) $this->date_created = date("Y-m-d H:i:s", strtotime($this->date_created));
		return true;
	    } else
		return false;
	}
    
	public function afterFind()
	{
		$this->title = Yii::t('servicecategory', $this->title);
		$this->date_updated = date('d-m-Y H:i:s', strtotime($this->date_updated));
		$this->date_created = date('d-m-Y H:i:s', strtotime($this->date_created));

		parent::afterFind();
	}
}
