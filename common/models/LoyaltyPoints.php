<?php
namespace common\models;
use yii\db\ActiveRecord;
use common\models\Merchant;
use Yii;

/**
 * This is the model class for table "loyalty_points".
 *
 * The followings are the available columns in table 'loyalty_points':
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $count_on_order
 * @property integer $count_on_like
 * @property integer $is_active
 * @property integer $count_on_comment
 * @property integer $count_on_rate
 *
 * The followings are the available model relations:
 * @property Merchant $merchant
 */
class LoyaltyPoints extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'loyalty_points';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['merchant_id', 'count_on_order', 'count_on_like', 'is_active', 'count_on_comment', 'count_on_rate'],'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['id, merchant_id, count_on_order, count_on_like, is_active, count_on_comment, count_on_rate', 'safe', 'on'=>'search'),
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
			'merchant_id' => Yii::t('basicfield','Merchant'),
			'count_on_order' => Yii::t('basicfield','Count On Order'),
			'count_on_like' => Yii::t('basicfield','Count On Like'),
			'is_active' => Yii::t('basicfield','Is Active'),
			'count_on_comment' => Yii::t('basicfield','Count On Comment'),
			'count_on_rate' => Yii::t('basicfield','Count On Rate'),
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
		$criteria->compare('count_on_order',$this->count_on_order);
		$criteria->compare('count_on_like',$this->count_on_like);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('count_on_comment',$this->count_on_comment);
		$criteria->compare('count_on_rate',$this->count_on_rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoyaltyPoints the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
