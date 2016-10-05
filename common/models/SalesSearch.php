<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sales;


/**
 * SalesSearch represents the model behind the search form about `common\models\Sales`.
 */
class SalesSearch extends Sales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'model', 'date', 'created_at', 'condition', 'price'], 'integer'],
            [['emei1', 'emei2', 'serial', 'img'], 'safe'],
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
    public function search($params, $user=false)
    {
        $query = Sales::find();

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
            'user_id' => $this->user_id,
            'model' => $this->model,
            'condition' => $this->condition,
            'price' => $this->price,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'emei1', $this->emei1])
            ->andFilterWhere(['like', 'emei2', $this->emei2])
            ->andFilterWhere(['like', 'serial', $this->serial])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
			->orderBy(['condition' => SORT_ASC]);

		if( $user ) {
			$query->andFilterWhere(['=', 'user_id', $user]);
		}

        return $dataProvider;
    }
}
