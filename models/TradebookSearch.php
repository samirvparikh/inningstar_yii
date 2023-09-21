<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tradebook;

/**
 * TradebookSearch represents the model behind the search form of `app\models\Tradebook`.
 */
class TradebookSearch extends Tradebook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'watchlist_id', 'quantity', 'status', 'created_by', 'created_dt', 'updated_by', 'updated_dt'], 'integer'],
            [['price', 'amount'], 'number'],
            [['date', 'ip_address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Tradebook::find();

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
            'watchlist_id' => $this->watchlist_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'amount' => $this->amount,
            'date' => $this->date,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
        ]);

        $query->andFilterWhere(['like', 'ip_address', $this->ip_address]);

        return $dataProvider;
    }
}
