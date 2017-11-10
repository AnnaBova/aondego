<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form about `common\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'status', 'mobile_verification_code'], 'integer'],
            [['social_strategy', 'first_name', 'last_name', 'email_address', 'password', 'street', 'city', 'state', 'zipcode', 'country_code', 'location_name', 'contact_phone', 'lost_password_token', 'date_created', 'date_modified', 'last_login', 'ip_address', 'token', 'mobile_verification_date', 'custom_field1', 'custom_field2', 'auth_key', 'password_hash', 'password_reset_token', 'activation_key', 'dob'], 'safe'],
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
        $query = Client::find();

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
            'client_id' => $this->client_id,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
            'last_login' => $this->last_login,
            'status' => $this->status,
            'mobile_verification_code' => $this->mobile_verification_code,
            'mobile_verification_date' => $this->mobile_verification_date,
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'social_strategy', $this->social_strategy])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'location_name', $this->location_name])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'lost_password_token', $this->lost_password_token])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'custom_field1', $this->custom_field1])
            ->andFilterWhere(['like', 'custom_field2', $this->custom_field2])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'activation_key', $this->activation_key]);

        return $dataProvider;
    }
}
