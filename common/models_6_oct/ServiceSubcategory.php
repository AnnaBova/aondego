<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "{{service_subcategory}}".
 *
 * The followings are the available columns in table '{{service_subcategory}}':
 * @property integer $id
 * @property integer $category_id
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
 * @property ServiceCategory $category
 */
class ServiceSubcategory extends ActiveRecord
{
    const UPLOAD_DIR = 'subcategory';
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_service_subcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			[['category_id', 'title', 'date_created', 'url'], 'required'],
            [['category_id', 'is_active', 'is_approved', 'merchant_id', 'is_group'], 'integer'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['title', 'url', 'seo_title', 'seo_description', 'seo_keywords'], 'string', 'max' => 255],
            [['approved_text'], 'string', 'max' => 500],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
		);
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => \frontend\components\ImageBehavior::className(),
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
			'category' => array(self::BELONGS_TO, 'ServiceCategory', 'category_id'),
            'hasMerchant' => array(self::HAS_MANY, 'CategoryHasMerchant', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => Yii::t('app','Category'),
			'title' => Yii::t('app','Title'),
			'description' => Yii::t('app','Description'),
			'is_active' => Yii::t('app','Is Active'),
			'is_approved' => Yii::t('app','Is Approved'),
			'approved_text' => Yii::t('app','Approved Text'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated' => Yii::t('app','Date Updated'),
			'merchant_id' => Yii::t('app','Merchant'),
            'is_group' => Yii::t('app','Group Service')
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
	public function getCategoryHasMerchants()
        {
            return $this->hasMany(CategoryHasMerchant::className(), ['category_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategory()
        {
            return $this->hasOne(ServiceCategory::className(), ['id' => 'category_id']);
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceSubcategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(!$this->isNewRecord) $this->date_updated = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            return true;
        } else
            return false;
    }

    public function getTitleFull(){
        if($this->is_group){
            return $this->title.' (group)';
        }else
        {
            return $this->title;
        }
    }
}
