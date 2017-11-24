<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;

class Comment extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'comments';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['user_id',  'body'], 'required'],
			[['user_id', 'review_id'], 'integer'],
			[['body'], 'string', 'max'=>500]
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
			'parent_id' => Yii::t('basicfield','Parent Id'),
			'review_id' => Yii::t('basicfield','Review Id'),
			'user_id' => Yii::t('basicfield','User Id'),
			'body' => Yii::t('basicfield','Body'),
			'created_at' => Yii::t('basicfield','Created At'),
			'updated_at' => Yii::t('basicfield','Updated At'),
		);
	}

}