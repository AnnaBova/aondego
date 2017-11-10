<?php

/**
 * This is the model class for table "schedule_days_template".
 *
 * The followings are the available columns in table 'schedule_days_template':
 * @property integer $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property StaffSchedule[] $staffSchedules
 * @property TimeRange[] $timeRanges
 */
class ScheduleDaysTemplate extends CActiveRecord
{
    public $oneMany = [];

    public function primaryKey(){
        return 'id';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'schedule_days_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            ['title, merchant_id','required'],
			array('title', 'length', 'max'=>45),
            ['oneMany','safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors(){
        return array(
            'oneManyBehavior' => array(
                'class' => 'OneManyBehavior',
                'fields'=> [['attr'=>'time_from','label'=>'Time From', 'type'=>'time'], ['attr'=>'time_to','label'=>'Time To', 'type'=>'time'],],
                'relation' => 'timeRanges',
                'relationModel' => 'TimeRange',
                'parent_column_name' => 'schedule_days_template_id'
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
			'timeRanges' => array(self::HAS_MANY, 'TimeRange', 'schedule_days_template_id'),
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
            'oneMany' => Yii::t('default','Time Range')
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
        $criteria->addCondition('merchant_id='.Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScheduleDaysTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
