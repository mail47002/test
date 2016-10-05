<?php

namespace common\models;

use common\models\User;
use common\models\Profile;
use common\models\Prizes;
use common\models\Sales;
use common\models\Rating;
use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "gifts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $model
 * @property integer $price
 * @property integer $created_at
 * @property integer $status
 */
class Gifts extends ActiveRecord
{
	static $user;
    const STATUS_REJECTED = 0;
    const STATUS_PENDING = 1;
    const STATUS_SELECTED = 5;
    const STATUS_PROOF = 10;
    const STATUS_ISSUED = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gifts}}';
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
					ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
				],
				'value' => function() { return date('U'); },
			],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model', 'price', 'created_at'], 'required'],
            [['user_id', 'model', 'price', 'created_at', 'condition', 'rating'], 'integer'],
        ];
    }


    /**
     * Finds gift by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
    }


    /**
     * @inheritdoc
     */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}


    /**
     * @inheritdoc
     */
	public function getPrizes()
	{
		return $this->hasOne(Prizes::className(), ['id' => 'model']);
	}


    /**
     * @inheritdoc
     */
    public static function countUserGifts($id)
    {
        return self::find()
				->where(['=', 'user_id', $id])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function countApproved($id)
    {
        return self::find()
				->where(['=', 'user_id', $id])
				->andwhere(['>=', 'condition', 1])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function countAllApproved()
    {
        return self::find()
				->where(['>=', 'condition', 1])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function countNotIssued()
    {
        return self::find()
				->where(['not in', 'condition', [0,20]])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function getPointsForUser($id)
    {
        $sql = self::find()
				->where(['=', 'user_id', $id])
				->andwhere(['>=', 'condition', 1])
				->all();
		$total = 0;
		foreach( $sql as $sale ) {
			$total += $sale->price;
		}
		return $total;
    }


    /**
     * Change status
     */
    public function changeStatus($status) {

		$message_type = 'success';
		if( $status == 77 && $this->model == 0 ) {

			$this->condition = 1;
			$message = 'Статус подарка восстановлен, помечен как "Не выбран".';

		} elseif( $status == 77 && $this->model != 0 ) {

			$this->condition = 5;
			$message = 'Статус подарка восстановлен, помечен как "Выбранный".';

		} elseif( $status == 0 && ( $this->condition == 5 || $this->condition == 1 ) ) {

			$this->condition = 0;
			$message = 'Подарок отклонен.';

		} elseif( $status == 10 && $this->condition == 5 ) {

			$this->condition = 10;
			$message = 'Подарок одобрен.';

		} elseif( $status == 20 && $this->condition == 10 ) {

			$this->condition = 20;
			$message = 'Подарок помечен как выданный.';

		} else {
			$message = 'Действие невозможно.';
			$message_type = 'error';
		}

		if ($this->save()) {
			Yii::$app->session->setFlash($message_type, $message);
			return true;
		} else {
			Yii::$app->session->setFlash('error', 'Ошибка при изменении статуса подарка.');
			return null;
		}
	}


    /**
     * @inheritdoc
     */
    public function registerNew($user_id, $scores, $place, $apportionment)
    {


		if( $scores == 0 || $scores == '' || !$scores ) {
			return null;
		}

		$count = 1;
		foreach($apportionment as $id => $section) {
			for( $i=0; $i < (int)$section['points']; $i++ ) {
				if($place == $count) {
					$prizes = Prizes::countPrizesByCat($id);
					if($prizes == 0) {
						Yii::$app->session->setFlash('error', 'Произошла ошибка, нет призов в выбранной категории.');
						return null;
					}
					if($prizes == 1) {
						$prize = Prizes::getOneByCat($id);
						$this->model = $prize->id;
						$this->condition = self::STATUS_SELECTED;
					} else {
						$this->model = 0;
						$this->condition = self::STATUS_PENDING;
					}
					break(2);
				}
				$count++;
			}
		}

		$this->user_id = $user_id;
		$this->price = $scores;
		$rating = Rating::findCurrent();
		$this->rating = $rating->id;
		$this->place = $place;

		if( !$this->save(false) ) {
			Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные подарка.');
			return null;
		}

		// Debit score points
		$profile = Profile::findById($user_id);
		$profile->debitRatingPoints();

		// Mark sales as archive
		while( $sale = Sales::findByUserId($user_id) ) {
			if(!$sale->toArchive()) {
				Yii::$app->session->setFlash('error', 'Ошибка изменения статуса продажи.');
				return false;
			}
		}

		return true;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Продавец',
            'model' => 'Наименование',
            'price' => 'Баллов',
            'created_at' => 'Создано',
            'condition' => 'Статус',
			'place' => 'Место в рейтинге',
			'rating' => '# рейтинга',
        ];
    }











    /**
     * @inheritdoc
     */
    private static function expandSettings($gift)
    {
		$product = Products::findById($gift->model);
		if( !isset(self::$user) || self::$user->id != $gift->user_id ) {
			self::$user = User::findUserById($gift->user_id);
		}

		return [
			'model_id' => $gift->model,
			'model' => $product->name,
			'user_id' => $gift->user_id,
			'user_name' => self::$user->username,
			'created_at' => $gift->created_at,
			'price' => $gift->price,
			'condition' => $gift->condition,
		];
    }

    /**
     * @inheritdoc
     */
    public static function getUnverificatedArray()
    {

        $gifts = self::find()
				->where(['=', 'condition', 1])
				->orderBy('id')
				->all();
		$sort_gifts = [];

		foreach ($gifts as $gift) {

			$sort_gifts[$gift->id] = self::expandSettings($gift);
		}
		return $sort_gifts;
    }
}
