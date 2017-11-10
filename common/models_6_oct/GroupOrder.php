<?php
namespace common\models;
use common\models\Order;
/**
 * This is the model class for table "group_order".
 *
 * The followings are the available columns in table 'group_order':
 * @property integer $id
 * @property integer $client_id
 * @property string $client_name
 * @property string $client_phone
 * @property string $client_email
 * @property integer $category_id
 * @property integer $order_time
 * @property string $more_info
 * @property double $price
 * @property integer $is_payd
 * @property integer $status
 */
class GroupOrder extends Order
{
    public $g_cache;
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['client_name', 'client_phone', 'client_email', 'order_time', 'category_id'], 'required'],
            [['status', 'staff_id', 'client_id', 'payment_type', 'category_id', 'status', 'merchant_id'], 'integer'],
            [['client_name', 'client_phone', 'client_email'], 'string', 'max' => 50],
            [['order_time', 'addons_list','g_cache'], 'safe'],
            ['more_info', 'string', 'max'=>510],
            ['price', 'integer'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('id, status, client_id, payment_type, client_name, client_phone, client_email, order_time, category_id', 'safe', 'on' => 'search'),
        ];
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_phone',$this->client_phone,true);
		$criteria->compare('client_email',$this->client_email,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('order_time',$this->order_time);
		$criteria->compare('more_info',$this->more_info,true);
		$criteria->compare('price',$this->price);
        $criteria->addCondition('merchant_id='.Yii::app()->user->id);
        $criteria->addCondition('status != 2');
        $criteria->addCondition('is_group = 1');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function defaultScope()
    {
        return array(
            'condition'=> 'is_group= 1 AND status!=2',
        );
    }


    public static function countByDate($date, $service_id){
        return self::find()->where(['order_time'=>$date,'category_id'=>$service_id,'status'=>0])->count() + CachedSingleOrder::countGroupByDay($service_id,$date);
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) $this->is_group = 1;
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
       CachedSingleOrder::deleteGroupByDay($this->category_id,$this->order_time,$this->g_cache);
        parent::afterSave($insert, $changedAttributes);
    }


}
