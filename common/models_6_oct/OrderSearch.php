<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'client_id', 'payment_type', 'category_id', 'staff_id', 'merchant_id', 'is_group', 'source_type', 'order_id', 'commision_ontop', 'voucher_id'], 'integer'],
            [['client_name', 'client_phone', 'client_email', 'order_time', 'create_time', 'more_info', 'voucher_code', 'voucher_type'], 'safe'],
            [['price', 'discounted_amount', 'discount_percentage', 'percent_commision', 'total_commission', 'merchant_earnings', 'voucher_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'client_id' => $this->client_id,
            'payment_type' => $this->payment_type,
            'order_time' => $this->order_time,
            'category_id' => $this->category_id,
            'staff_id' => $this->staff_id,
            'merchant_id' => $this->merchant_id,
            'create_time' => $this->create_time,
            'is_group' => $this->is_group,
            'source_type' => $this->source_type,
            'order_id' => $this->order_id,
            'price' => $this->price,
            'discounted_amount' => $this->discounted_amount,
            'discount_percentage' => $this->discount_percentage,
            'percent_commision' => $this->percent_commision,
            'total_commission' => $this->total_commission,
            'commision_ontop' => $this->commision_ontop,
            'merchant_earnings' => $this->merchant_earnings,
            'voucher_amount' => $this->voucher_amount,
            'voucher_id' => $this->voucher_id,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'client_phone', $this->client_phone])
            ->andFilterWhere(['like', 'client_email', $this->client_email])
            ->andFilterWhere(['like', 'more_info', $this->more_info])
            ->andFilterWhere(['like', 'voucher_code', $this->voucher_code])
            ->andFilterWhere(['like', 'voucher_type', $this->voucher_type]);
        
        if($this->is_group == 1){
            $query->andWhere(['<>','status', 2]);
        }

        return $dataProvider;
    }
}
