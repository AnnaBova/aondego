<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Voucher;

/**
 * VoucherSearch represents the model behind the search form about `common\models\Voucher`.
 */
class VoucherSearch extends Voucher
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voucher_id', 'merchant_id', 'status', 'used_once', 'service_id'], 'integer'],
            [['voucher_owner', 'joining_merchant', 'voucher_name', 'voucher_type', 'expiration', 'date_created', 'date_modified'], 'safe'],
            [['amount'], 'number'],
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
        $query = Voucher::find();

       $pageSize = isset($params['per-page']) ? $params['per-page'] : 10;
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'voucher_id' => $this->voucher_id,
            'merchant_id' => $this->merchant_id,
            'amount' => $this->amount,
            'expiration' => $this->expiration,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
            'used_once' => $this->used_once,
            'service_id' => $this->service_id,
        ]);

        $query->andFilterWhere(['like', 'voucher_owner', $this->voucher_owner])
            ->andFilterWhere(['like', 'joining_merchant', $this->joining_merchant])
            ->andFilterWhere(['like', 'voucher_name', $this->voucher_name])
            ->andFilterWhere(['like', 'voucher_type', $this->voucher_type]);

        return $dataProvider;
    }
}
