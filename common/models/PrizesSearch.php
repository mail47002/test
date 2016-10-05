<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Prizes;

/**
 * PrizesSearch represents the model behind the search form about `common\models\Prizes`.
 */
class PrizesSearch extends Prizes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat', 'manufacturer', 'draft', 'gift'], 'integer'],
            [['name', 'description', 'excerpt', 'url', 'img'], 'safe'],
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
    public function search($params, $expand=false)
    {
        $query = Prizes::find();

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
            'cat' => $this->cat,
            'manufacturer' => $this->manufacturer,
            'draft' => $this->draft,
            'gift' => $this->gift,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'excerpt', $this->excerpt])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'img', $this->img]);

		if( $expand ) {
			$query->JoinWith('manufacturers')->orderBy('manufacturers.id, prizes.manufacturer');
		}

        return $dataProvider;
    }
}
