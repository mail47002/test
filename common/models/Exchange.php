<?php

namespace common\models;

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
     * Finds user profile by user id
     *
     * @param integer $id
     * @return static|null
     */
    public function getTopPlaces()
    {
		$limit = RatingSections::countTotalPoints();
		$sql = self::find()
				->JoinWith('user')
				->orderBy('user.id, profile.id')
				->where(['=', 'user.status', 10])
				->andwhere(['=', 'user.role', 6])
				->all();

/*		foreach($sql as $profile) {
			$result_set[$counter] = [
				'user' => $profile->id,
				'scores' => $profile->scores,
			];
			$counter++;
		}*/

		return $sql;
    }
}
