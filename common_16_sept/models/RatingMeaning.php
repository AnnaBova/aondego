<?php

/**
 * This is the model class for table "{{rating_meaning}}".
 *
 * The followings are the available columns in table '{{rating_meaning}}':
 * @property integer $id
 * @property double $rating_start
 * @property double $rating_end
 * @property string $meaning
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 */
class RatingMeaning extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rating_meaning}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating_start, rating_end, meaning, date_created, date_modified, ip_address', 'required'),
			array('rating_start, rating_end', 'numerical'),
			array('meaning', 'length', 'max'=>255),
			array('ip_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rating_start, rating_end, meaning, date_created, date_modified, ip_address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rating_start' => Yii::t('default','Rating Start'),
			'rating_end' => Yii::t('default','Rating End'),
			'meaning' => Yii::t('default','Meaning'),
			'date_created' => Yii::t('default','Date Created'),
			'date_modified' => Yii::t('default','Date Modified'),
			'ip_address' => Yii::t('default','Ip Address'),
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
		$criteria->compare('rating_start',$this->rating_start);
		$criteria->compare('rating_end',$this->rating_end);
		$criteria->compare('meaning',$this->meaning,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RatingMeaning the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterFind() {
        $this->rating_start = Yii::app()->format->number($this->rating_start);
        $this->rating_end = Yii::app()->format->number($this->rating_end);

         parent::afterFind();
    }

    public function beforeValidate() {
        $this->rating_start = Yii::app()->format->unformatNumber($this->rating_start);
        $this->rating_end = Yii::app()->format->unformatNumber($this->rating_end);
        return parent::beforeValidate();
    }
}
