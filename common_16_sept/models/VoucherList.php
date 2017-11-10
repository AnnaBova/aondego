<?php

/**
 * This is the model class for table "{{voucher_list}}".
 *
 * The followings are the available columns in table '{{voucher_list}}':
 * @property integer $voucher_id
 * @property string $voucher_code
 * @property string $status
 * @property integer $client_id
 * @property string $date_used
 * @property integer $order_id
 */
class VoucherList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{voucher_list}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('voucher_id, voucher_code, client_id, date_used, order_id', 'required'),
			array('voucher_id, client_id, order_id', 'numerical', 'integerOnly'=>true),
			array('voucher_code, status, date_used', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('voucher_id, voucher_code, status, client_id, date_used, order_id', 'safe', 'on'=>'search'),
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
			'voucher_id' => Yii::t('default','Voucher'),
			'voucher_code' => Yii::t('default','Voucher Code'),
			'status' => Yii::t('default','Status'),
			'client_id' => Yii::t('default','Client'),
			'date_used' => Yii::t('default','Date Used'),
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

		$criteria->compare('voucher_id',$this->voucher_id);
		$criteria->compare('voucher_code',$this->voucher_code,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('date_used',$this->date_used,true);
		$criteria->compare('order_id',$this->order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VoucherList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
