<?php
namespace common\models;

use common\models\User;
use common\models\ProfileDetails;
use common\models\RatingSections;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * Profile model
 *
 * @property integer $id
 * @property string $img
 * @property string $user_num
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property integer $birthday
 * @property string $gender
 * @property integer $district
 * @property string $city
 * @property string $phone
 * @property string $education
 * @property string $work_expiriance
 * @property string $company_expiriance
 * @property string $subdivision
 * @property string $subdivision_id
 * @property string $position
 * @property string $position_id
 * @property string $organization
 * @property string $organization_address
 * @property string $category
 * @property string $category_id
 */

class Profile extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'birthday',
				],
				'value' => function() { return date('U'); },
			],
		];
    }

    /**
     * Finds user profile by user id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
		return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id']);
	}

    /**
     * Finds users by points
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
				->andwhere(['>', 'profile.scores', 0])
				->orderBy(['profile.scores' => SORT_DESC])
				->limit($limit)
				->all();
		$counter = 1;
		foreach($sql as $profile) {
			$result_set[$counter] = [
				'user' => $profile->id,
				'scores' => $profile->scores,
			];
			$counter++;
		}

		return $result_set;
    }


    /**
     * Finds user profile by user id
     *
     * @param void
     * @return array
     */
    public function getStudentsList()
    {
		$sql = self::find()
				->JoinWith('user')
				->orderBy('user.id, profile.id')
				->where(['=', 'user.status', 10])
				->andwhere(['=', 'user.role', 5])
				->all();
		$result_set['Staff'] = [];
		foreach($sql as $profile) {
			$result_set['Staff'][$profile->id] = [
				'user_num' => 'smp-' . $profile->id,
				'login' => $profile->user->username,
				'password' => $profile->sdo_password,
				'firstname' => $profile->firstname,
				'middlename' => $profile->middlename,
				'lastname' => $profile->lastname,
				'birthday' => $profile->birthday,
				'gender' => ProfileDetails::getItemName($profile->gender),
				'district' => ProfileDetails::getItemName($profile->district),
				'city' => $profile->city,
				'phone' => $profile->phone,
				'education' => ProfileDetails::getItemName($profile->education),
				'work_expiriance' => $profile->work_expiriance,
				'company_expiriance' => $profile->company_expiriance,
				'subdivision' => ProfileDetails::getItemName($profile->subdivision),
				'subdivision_num' => 'smp-sub-' . $profile->subdivision,
				'position' => ProfileDetails::getItemName($profile->position),
				'position_num' => 'smp-pos-' . $profile->position,
				'organization' => $profile->organization,
				'organization_address' => $profile->organization_address,
				'category' => ProfileDetails::getItemName($profile->category),
				'category_num' => 'smp-cat-' . $profile->category,
				//'' => $profile->,
				//'' => $profile->,
			];
			if( !$result_set['Staff'][$profile->id]['birthday'] || $result_set['Staff'][$profile->id]['birthday'] == '0' ) {
				$result_set['Staff'][$profile->id]['birthday'] = '';
			} else {
				$result_set['Staff'][$profile->id]['birthday'] = \Yii::$app->formatter->asDatetime($result_set['Staff'][$profile->id]['birthday'], \Yii::$app->params['dateFormat']);
			}
			if( !$result_set['Staff'][$profile->id]['gender'] || $result_set['Staff'][$profile->id]['gender'] == '0' ) {
				$result_set['Staff'][$profile->id]['gender'] = '';
			}
		}
		if(!$result_set['Staff'] || empty($result_set['Staff'])) {
			$result_set['Staff'] = [];
		}

		return $result_set;
    }


    /**
     * Change scores
     */
    public function changeScores($scores, $sub=false) {
		if(!$sub) {
			$this->scores = $this->scores + $scores;
		} else {
			$this->scores = $this->scores - $scores;
		}

		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Баллы добавлены.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении баллов.');
		}
	}


    /**
     * Change user role
     */
    public function changeSdoPoints($points) {
        $this->sdo_points = $points;
		if ($this->save()) {
			return true;
		} else {
			return false;
		}
	}


    /**
     * Change user scores
     */
    public function debitRatingPoints() {
        $this->scores = 0;
		if ($this->save()) {
			return true;
		} else {
			return false;
		}
	}


    /**
     * @inheritdoc
     */
	public function generateAssociatedIdentificators()
	{
		$identificators['user_num'] = 'smp-' . $this->id;
		$identificators['subdivision_id'] = $this->subdivision==0?'':'smp-sub-' . $this->subdivision;
		$identificators['position_id'] = $this->position==0?'':'smp-pos-' . $this->position;
		$identificators['category_id'] = $this->category==0?'':'smp-cat-' . $this->category;
		return $identificators;
	}

    /**
     * @inheritdoc
     */
	public function getAssociatedData()
	{
		$this->gender = ProfileDetails::getItemName($this->gender);
		$this->district = ProfileDetails::getItemName($this->district);
		$this->education = ProfileDetails::getItemName($this->education);
		$this->subdivision = ProfileDetails::getItemName($this->subdivision);
		$this->position = ProfileDetails::getItemName($this->position);
		$this->category = ProfileDetails::getItemName($this->category);
	}


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'user_num' => 'Табельный номер',
            'img' => 'Аватар',
			'firstname' => 'Имя',
			'middlename' => 'Отчество',
			'lastname' => 'Фамилия',
            'birthday' => 'Дата рождения',
            'gender' => 'Пол',
			'district' => 'Область',
			'city' => 'Город/Населенный пункт',
			'phone' => 'Телефон',
            'education' => 'Образование',
            'work_expiriance' => 'Стаж работы (мес.)',
            'company_expiriance' => 'Стаж работы в компании (мес.)',
            'subdivision' => 'Подразделение (Сеть)',
            'subdivision_id' => 'Код подразделения',
			'position' => 'Должность',
            'position_id' => 'Код должности',
			'organization' => 'Организация (Название компании)',
            'organization_address' => 'Адрес организации',
            'category' => 'Категория',
            'category_id' => 'Код категории',
            'sdo_points' => 'Набрано баллов на обучении',
            'sdo_password' => 'Пароль СДО',
			'username' => 'Логин',
			'scores' => 'Текущий рейтинг',
		];
	}

}