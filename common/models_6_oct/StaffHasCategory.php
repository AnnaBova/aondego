<?php
namespace common\models;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "staff_has_category".
 *
 * The followings are the available columns in table 'staff_has_category':
 * @property integer $id
 * @property integer $staff_id
 * @property integer $category_id
 *
 * The followings are the available model relations:
 * @property ServiceSubcategory $category
 * @property Staff $staff
 */
class StaffHasCategory extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'staff_has_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			[['staff_id', 'category_id'], 'required'],
			[['staff_id', 'category_id'],'integer'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, staff_id, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'CategoryHasMerchant', 'category_id'),
			'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staff_id' => Yii::t('default','Staff'),
			'category_id' => Yii::t('default','Category'),
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
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffHasCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
