<?php
namespace common\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "merch_cat_has_addon".
 *
 * The followings are the available columns in table 'merch_cat_has_addon':
 * @property integer $id
 * @property integer $m_c_id
 * @property integer $addon_id
 *
 * The followings are the available model relations:
 * @property CategoryHasMerchant $mC
 * @property Addon $addon
 */
class MerchCatHasAddon extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'merch_cat_has_addon';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['m_c_id', 'addon_id'], 'required'],
			[['m_c_id', 'addon_id'],'integer'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//['id, m_c_id, addon_id', 'safe', 'on'=>'search'),
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
			'mC' => array(self::BELONGS_TO, 'CategoryHasMerchant', 'm_c_id'),
			'addon' => array(self::BELONGS_TO, 'Addon', 'addon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'm_c_id' => 'M C',
			'addon_id' => Yii::t('basicfield','Add-on'),
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
		$criteria->compare('m_c_id',$this->m_c_id);
		$criteria->compare('addon_id',$this->addon_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MerchCatHasAddon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
