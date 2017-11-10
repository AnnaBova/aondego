<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Packages;

/**
 * PackagesSearch represents the model behind the search form about `common\models\Packages`.
 */
class PackagesSearch extends Packages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'expiration', 'expiration_type', 'unlimited_post', 'post_limit', 'sequence', 'status', 'sell_limit', 'workers_limit', 'is_commission', 'commission_type'], 'integer'],
            [['title', 'description', 'date_created', 'date_modified'], 'safe'],
            [['price', 'promo_price', 'percent_commission', 'fixed_commission'], 'number'],
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
        $query = Packages::find();

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
            'package_id' => $this->package_id,
            'price' => $this->price,
            'promo_price' => $this->promo_price,
            'expiration' => $this->expiration,
            'expiration_type' => $this->expiration_type,
            'unlimited_post' => $this->unlimited_post,
            'post_limit' => $this->post_limit,
            'sequence' => $this->sequence,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
            'sell_limit' => $this->sell_limit,
            'workers_limit' => $this->workers_limit,
            'is_commission' => $this->is_commission,
            'commission_type' => $this->commission_type,
            'percent_commission' => $this->percent_commission,
            'fixed_commission' => $this->fixed_commission,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
