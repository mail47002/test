<?php

namespace console\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Profile;
use common\models\User;

/**
 * Exchange represents the model behind the search form about `common\models\Profile`.
 */
class Exchange extends Profile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'birthday', 'district', 'work_expiriance', 'company_expiriance'], 'integer'],
            [['img', 'firstname', 'middlename', 'lastname', 'gender', 'city', 'phone', 'education', 'subdivision', 'position', 'organization', 'category'], 'safe'],
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
        $query = Profile::find();

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
            'birthday' => $this->birthday,
            'district' => $this->district,
            'work_expiriance' => $this->work_expiriance,
            'company_expiriance' => $this->company_expiriance,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'subdivision', $this->subdivision])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'category', $this->category]);
		$query->JoinWith('user')
			->orderBy('user.id, profile.id');
		$query->andFilterWhere(['=', 'user.role', 6])
			->andFilterWhere(['=', 'user.status', 10]);

        return $dataProvider;
    }
}
