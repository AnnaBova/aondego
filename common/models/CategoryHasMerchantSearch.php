<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CategoryHasMerchant;

/**
 * CategoryHasMerchantSearch represents the model behind the search form about `common\models\CategoryHasMerchant`.
 */
class CategoryHasMerchantSearch extends CategoryHasMerchant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'merchant_id', 'is_active', 'id', 'time_in_minutes', 'additional_time', 'service_time_slot', 'group_people', 'is_group', 'staff_id'], 'integer'],
            [['price'], 'number'],
            [['title', 'color', 'description'], 'safe'],
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
        $query = CategoryHasMerchant::find();

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
            'category_id' => $this->category_id,
            'merchant_id' => $this->merchant_id,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'id' => $this->id,
            'time_in_minutes' => $this->time_in_minutes,
            'additional_time' => $this->additional_time,
            'service_time_slot' => $this->service_time_slot,
            'group_people' => $this->group_people,
            'is_group' => $this->is_group,
            'staff_id' => $this->staff_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'description', $this->description]);
        
        $query->orderBy('id desc');

        return $dataProvider;
    }
}
