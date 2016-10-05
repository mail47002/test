<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * Sales model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property integer $given_at
 * @property integer $created_at
 * @property integer $status
 */
class Gifts extends ActiveRecord
{
	static $user;

	public function __construct()
	{

	}

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
			'status' => $gift->status,
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
    public function registerNew($user_id, $product_id, $price)
    {
		$this->user_id = $user_id;
		$this->model = $product_id;
		$this->price = $price;
		if (!$this->save()) {
			Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные подарка.');
			return null;
		}

		return true;
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
    public static function getAll()
    {
        return self::find()
				->orderBy('status')
				->all();
    }


    /**
     * @inheritdoc
     */
    public static function getAllForUserArray($id)
    {
        $gifts = self::find()
				->where(['=', 'user_id', $id])
				->all();
		$sort_gifts = [];

		foreach ($gifts as $gift) {

			$sort_gifts[$gift->id] = self::expandSettings($gift);
		}
		return $sort_gifts;
    }


    /**
     * @inheritdoc
     */
    public static function getUnverificatedArray()
    {

        $gifts = self::find()
				->where(['=', 'status', 1])
				->orderBy('id')
				->all();
		$sort_gifts = [];

		foreach ($gifts as $gift) {

			$sort_gifts[$gift->id] = self::expandSettings($gift);
		}
		return $sort_gifts;
    }


    /**
     * @inheritdoc
     */
    public static function getAllExpandedArray()
    {
        $gifts = self::find()
				->orderBy('status')
				->all();
		$sort_gifts = [];

		foreach ($gifts as $gift) {
			$sort_gifts[$gift->id] = self::expandSettings($gift);
		}
		return $sort_gifts;
    }


    /**
     * @inheritdoc
     */
    public static function countApproved($id)
    {
        return self::find()
				->where(['=', 'user_id', $id])
				->andwhere(['=', 'status', 20])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function countAllApproved()
    {
        return self::find()
				->where(['=', 'status', 20])
				->count();
    }

    /**
     * @inheritdoc
     */
    public static function getPointsForUser($id)
    {
        $sql = self::find()
				->where(['=', 'user_id', $id])
				->andwhere(['>=', 'status', 1])
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
			$this->status = $status;
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Статус подарка обновлен.');
		} else {
			Yii::$app->session->setFlash('error', 'Ошибка при изменении статуса подарка.');
		}
	}
}