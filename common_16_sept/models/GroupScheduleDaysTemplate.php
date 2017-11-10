<?php

/**
 * This is the model class for table "group_schedule_days_template".
 *
 * The followings are the available columns in table 'group_schedule_days_template':
 * @property integer $id
 * @property string $title
 * @property integer $merchant_id
 *
 * The followings are the available model relations:
 * @property GroupTimeRange[] $groupTimeRanges
 */
class GroupScheduleDaysTemplate extends CActiveRecord
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
		return 'group_schedule_days_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, merchant_id', 'required'),
			array('merchant_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
            ['oneMany','safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, merchant_id', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors(){
        return array(
            'oneManyBehavior' => array(
                'class' => 'OneManyBehavior',
                'fields'=> [['attr'=>'time_start','label'=>'Time Start', 'type'=>'time'],],
                'relation' => 'groupTimeRanges',
                'relationModel' => 'GroupTimeRange',
                'parent_column_name' => 'group_schedule_days_template_id'
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
			'groupTimeRanges' => array(self::HAS_MANY, 'GroupTimeRange', 'group_schedule_days_template_id'),
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
			'merchant_id' => Yii::t('default','Merchant'),
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
	 * @return GroupScheduleDaysTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
