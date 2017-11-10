<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MerchantAppointmentCancelSetup;

/**
 * MerchantAppointmentCancelSetupSearch represents the model behind the search form of `common\models\MerchantAppointmentCancelSetup`.
 */
class MerchantAppointmentCancelSetupSearch extends MerchantAppointmentCancelSetup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cancel_hour_from', 'cancel_hour_to'], 'integer'],
            [['cancel_percent', 'created_at', 'updated_at'], 'safe'],
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
        $query = MerchantAppointmentCancelSetup::find();

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
            'cancel_hour_from' => $this->cancel_hour_from,
            'cancel_hour_to' => $this->cancel_hour_to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'cancel_percent', $this->cancel_percent]);

        return $dataProvider;
    }
}
