<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Profile;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{

	public $subdivision;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'status', 'created_at', 'updated_at', 'role', 'subdivision'], 'integer'],
			[['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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
	public function search($params, $flag=false)
	{

		$query = User::find();

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

 
		/**
		 * Настройка параметров сортировки
		 * Важно: должна быть выполнена раньше $this->load($params)
		 * statement below
		 */
		$dataProvider->setSort([
			'attributes' => [
				'id',
				'username',
				'subdivision',
				'email',
				'role',
				'created_at'
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
				'username' => $this->username,
				'email' => $this->email,
				'created_at' => $this->created_at,
				'role' => $this->role,
				'profile.subdivision' => $this->subdivision,
			]);

			$query->andFilterWhere(['like', 'auth_key', $this->auth_key])
				->andFilterWhere(['like', 'password_hash', $this->password_hash])
				->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
				->andFilterWhere(['like', 'profile.subdivision', $this->subdivision]);

			//$query->orderBy('role');

		if( $flag == 'rating' ) {
			$query->JoinWith('profile')->orderBy('profile.id, user.id');
			$query->andFilterWhere(['=', 'role', 10])
				->andFilterWhere(['=', 'status', 10])
				->andFilterWhere(['>', 'profile.scores', 0]);
			// grid filtering conditions
			$query->orderBy(['profile.scores' => SORT_DESC]);

		} if( $flag == 'details' ) {
			$query->JoinWith('profile');
			$query->andFilterWhere(['not in', 'user.id', \Yii::$app->user->identity->id])
					->andFilterWhere(['<=', 'user.role', \Yii::$app->user->identity->role]);

		} else {
			$query->andFilterWhere(['not in', 'id', \Yii::$app->user->identity->id])
				->andFilterWhere(['<=', 'role', \Yii::$app->user->identity->role]);
		}


		return $dataProvider;
	}
}
