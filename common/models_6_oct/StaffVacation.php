<?php
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "staff_vacation".
 *
 * The followings are the available columns in table 'staff_vacation':
 * @property integer $id
 * @property integer $staff_id
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 */
class StaffVacation extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'staff_vacation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			//['staff_id', 'required'),
			['staff_id','integer'],
			['remark', 'string', 'max'=>510],
			[['start_date', 'end_date'], 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, staff_id, start_date, end_date, remark', 'safe', 'on'=>'search'),
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
            'staff' => array(self::BELONGS_TO, 'Staff', 'staff_id'),
		);
	}
        
        public function getStaff(){
            return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staff_id' => Yii::t('app','Staff'),
			'start_date' => Yii::t('app','Start Date'),
			'end_date' => Yii::t('app','End Date'),
			'remark' => Yii::t('app','Remark'),
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
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('remark',$this->remark,true);
        $criteria->with = 'staff';
        $criteria->together = true;

        $criteria->addCondition('staff.merchant_id='.Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffVacation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
