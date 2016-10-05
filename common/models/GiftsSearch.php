<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Gifts;

/**
 * GiftsSearch represents the model behind the search form about `common\models\Gifts`.
 */
class GiftsSearch extends Gifts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'model', 'price', 'created_at', 'condition', 'rating', 'place'], 'integer'],
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
        $query = Gifts::find();

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
            'price' => $this->price,
            'created_at' => $this->created_at,
            'condition' => $this->condition,
            'rating' => $this->rating,
            'place' => $this->place,
        ]);

		$query->orderBy(['condition' => SORT_ASC]);

		if( $user ) {
			$query->andFilterWhere(['=', 'user_id', $user]);
		}

        return $dataProvider;
    }
}
