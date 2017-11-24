<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "{{review}}".
 *
 * The followings are the available columns in table '{{review}}':
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $client_id
 * @property string $review
 * @property double $rating
 * @property string $status
 * @property string $date_created
 * @property string $ip_address
 * @property string $order_id
 */
class Review extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'mt_review';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['merchant_id', 'client_id', 'review', 'rating', 'date_created', 'ip_address', 'order_id'], 'required'],
			[['merchant_id', 'client_id'],'integer'],
			['rating', 'integer'],
			['status', 'string', 'max'=>100],
			['ip_address', 'string', 'max'=>50],
			['order_id', 'string', 'max'=>14],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, merchant_id, client_id, review, rating, status, date_created, ip_address, order_id', 'safe', 'on'=>'search'),
		];
	}

	/**
	 * @return array relational rules.
	 */
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'merchant_id' => Yii::t('basicfield','Merchant'),
			'client_id' => Yii::t('basicfield','Client'),
			'review' => Yii::t('basicfield','Review'),
			'rating' => Yii::t('basicfield','Rating'),
			'status' => Yii::t('basicfield','Status'),
			'date_created' => Yii::t('basicfield','Date Created'),
			'ip_address' => Yii::t('basicfield','Ip Address'),
			'order_id' => Yii::t('basicfield','Order'),
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
	 * @return Review the static model class
	 */
	

    

    public function beforeValidate() {
        $this->rating = Yii::$app->format->unformatNumber($this->rating);

        return parent::beforeValidate();
    }
    
    public function getMerchant()
    {
        return $this->hasOne(Merchant::className(), ['merchant_id' => 'merchant_id']);
    }
    
    public function afterFind(){
        $this->date_created = date('d-m-Y H:i:s', strtotime($this->date_created));


        parent::afterFind();
    }


	/**
	 *  Get review with comments
	 * @return \yii\db\ActiveQuery
	 */
	public function withComments ()
	{
		return $this->hasMany(Comment::className(), ['review_id' => 'id']);
	}
}
