<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LoyaltyPoints;

/**
 * LoyaltyPointsSearch represents the model behind the search form about `common\models\LoyaltyPoints`.
 */
class LoyaltyPointsSearch extends LoyaltyPoints
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'merchant_id', 'count_on_order', 'count_on_like', 'is_active', 'count_on_comment', 'count_on_rate'], 'integer'],
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
        $query = LoyaltyPoints::find();

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
            'merchant_id' => $this->merchant_id,
            'count_on_order' => $this->count_on_order,
            'count_on_like' => $this->count_on_like,
            'is_active' => $this->is_active,
            'count_on_comment' => $this->count_on_comment,
            'count_on_rate' => $this->count_on_rate,
        ]);

        return $dataProvider;
    }
}
