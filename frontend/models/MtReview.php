<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mt_review".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $client_id
 * @property string $review
 * @property double $rating
 * @property string $status
 * @property string $date_created
 * @property string $ip_address
 * @property string $order_id
 * @property string $name
 * @property string $email
 */
class MtReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'client_id', 'review', 'rating', 'date_created', 'ip_address', 'order_id', 'name', 'email', 'food_review', 'price_review', 'punctuality_review', 'courtesy_review'], 'required'],
            [['merchant_id', 'client_id', 'food_review', 'price_review', 'punctuality_review', 'courtesy_review'], 'integer'],
            [['review'], 'string'],
            [['rating'], 'number'],
            [['date_created'], 'safe'],
            [['status'], 'string', 'max' => 100],
            [['ip_address', 'name', 'email'], 'string', 'max' => 50],
            [['order_id'], 'string', 'max' => 14],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'client_id' => 'Client ID',
            'review' => 'Review',
            'rating' => 'Rating',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'ip_address' => 'Ip Address',
            'order_id' => 'Order ID',
            'name' => 'Name',
            'email' => 'Email',
            'food_review' => 'Peris',
            'price_review' => 'Ambiente',
            'punctuality_review' => 'Mitarbeiter',
            'courtesy_review' => 'Sauberkeit',
        ];
    }
    public function getRating(){
        $rating =[
            0 => Yii::t('basicfield', 'I dont know'),
            1 => Yii::t('basicfield', 'Low'),
            2 => Yii::t('basicfield', 'Sufficient'),
            3 => Yii::t('basicfield', 'Good'),
            4 => Yii::t('basicfield', 'Excellent'),
            5 => Yii::t('basicfield', 'Super'),
        ];
        return $rating;
    }
    
    public function getClient(){
        return $this->hasOne(Client::className(),[ 'client_id'=> 'client_id']);
    }
    
    public function getMerchant(){
        return $this->hasOne(MtMerchant::className(),[ 'merchant_id'=> 'merchant_id']);
    }
}
