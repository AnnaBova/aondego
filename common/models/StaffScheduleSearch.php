<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StaffSchedule;

/**
 * StaffScheduleSearch represents the model behind the search form about `common\models\StaffSchedule`.
 */
class StaffScheduleSearch extends StaffSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'staff_id', 'schedule_days_template_id'], 'integer'],
            [['work_date', 'reason'], 'safe'],
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
        $query = StaffSchedule::find();

        // add conditions that should always apply here
        $query->joinWith(['staff']);
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
            'work_date' => $this->work_date,
            'status' => $this->status,
            'staff_id' => $this->staff_id,
            'schedule_days_template_id' => $this->schedule_days_template_id,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);
        
        $query->andFilterWhere(['like', 'staff.merchant_id', Yii::$app->user->id]);
        
        $query->orderBy('id desc');

        return $dataProvider;
    }
}
