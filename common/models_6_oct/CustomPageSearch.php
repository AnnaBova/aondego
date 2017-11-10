<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomPage;

/**
 * CustomPageSearch represents the model behind the search form about `common\models\CustomPage`.
 */
class CustomPageSearch extends CustomPage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sequence', 'status', 'open_new_tab', 'is_custom_link'], 'integer'],
            [['slug_name', 'page_name', 'content', 'seo_title', 'meta_description', 'meta_keywords', 'icons', 'assign_to', 'date_created', 'date_modified'], 'safe'],
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
        $query = CustomPage::find();

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
            'sequence' => $this->sequence,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
            'open_new_tab' => $this->open_new_tab,
            'is_custom_link' => $this->is_custom_link,
        ]);

        $query->andFilterWhere(['like', 'slug_name', $this->slug_name])
            ->andFilterWhere(['like', 'page_name', $this->page_name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'icons', $this->icons])
            ->andFilterWhere(['like', 'assign_to', $this->assign_to]);

        return $dataProvider;
    }
}
