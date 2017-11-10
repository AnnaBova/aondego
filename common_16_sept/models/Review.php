<?php

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
class Review extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{review}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('merchant_id, client_id, review, rating, date_created, ip_address, order_id', 'required'),
			array('merchant_id, client_id', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			array('status', 'length', 'max'=>100),
			array('ip_address', 'length', 'max'=>50),
			array('order_id', 'length', 'max'=>14),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, merchant_id, client_id, review, rating, status, date_created, ip_address, order_id', 'safe', 'on'=>'search'),
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
            'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'merchant_id' => Yii::t('default','Merchant'),
			'client_id' => Yii::t('default','Client'),
			'review' => Yii::t('default','Review'),
			'rating' => Yii::t('default','Rating'),
			'status' => Yii::t('default','Status'),
			'date_created' => Yii::t('default','Date Created'),
			'ip_address' => Yii::t('default','Ip Address'),
			'order_id' => Yii::t('default','Order'),
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
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('review',$this->review,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Review the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterFind() {
        $this->rating = Yii::app()->format->number($this->rating);

         parent::afterFind();
    }

    public function beforeValidate() {
        $this->rating = Yii::app()->format->unformatNumber($this->rating);

        return parent::beforeValidate();
    }
}
