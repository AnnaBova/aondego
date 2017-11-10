<?php

/**
 * This is the model class for table "addon".
 *
 * The followings are the available columns in table 'addon':
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property integer $category_id
 * @property integer $time_in_minutes
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Order[] $orders
 */
class Addon extends CActiveRecord
{
    const UPLOAD_DIR = 'addon';
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'addon';
	}

    public function primaryKey(){
        return 'id';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price', 'required'),
			array('merchant_id, time_in_minutes', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>45),
            array('image', 'file', 'types'=>'jpg, png','allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, price', 'safe', 'on'=>'search'),
            array('id, name, price', 'safe', 'on'=>'searchForMerchant'),
		);
	}

    public function behaviors(){
        return array(
            'imageBehavior' => array(
                'class' => 'ImageBehavior',
                'imagePath' => self::UPLOAD_DIR,
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
			'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
			'orders' => array(self::MANY_MANY, 'Order', 'addon_has_order(addon_id, order_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('default','Name'),
			'price' => Yii::t('default','Price'),
            'image' => Yii::t('default','Image'),
			'merchant_id' => Yii::t('default','Merchant'),
            'time_in_minutes'=>Yii::t('default','Time in minutes')
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchForMerchant()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('price',$this->price);
        $criteria->addCondition('merchant_id = '.Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Addon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function afterFind() {
        $this->price = Yii::app()->format->number($this->price);
         parent::afterFind();
    }

    public function beforeValidate() {
        $this->price = Yii::app()->format->unformatNumber($this->price);
        return parent::beforeValidate();
    }

    public function getNameWithPriceAndTime(){
        return $this->name.' '.$this->time_in_minutes.'/'.$this->price;
    }
}
