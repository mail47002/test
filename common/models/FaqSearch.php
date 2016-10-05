<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Taxonomy;

/**
 * FaqSearch represents the model behind the search form about `common\models\Post`.
 */
class FaqSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'draft', 'category', 'created_at'], 'integer'],
            [['slug', 'title', 'img', 'excerpt', 'content'], 'safe'],
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
    public function search($params, $tax=false)
    {
        $query = Post::find();

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
            'slug' => $this->slug,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'excerpt', $this->excerpt])
            ->andFilterWhere(['like', 'content', $this->content]);

		if( $tax ) {
			$query->andFilterWhere(['=', 'category', $tax])
				->andFilterWhere(['=', 'draft', 0]);
		} else {
			$query->andFilterWhere(['>', 'category', 10])
				->andFilterWhere(['<=', 'category', 16]);
		}

        return $dataProvider;
    }
}
