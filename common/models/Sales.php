<?php
namespace common\models;

use common\models\User;
use common\models\Profile;
use common\models\Products;
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
 * @property string $emei1
 * @property string $emei2
 * @property string $serial
 * @property integer $date
 * @property integer $created_at
 * @property string $img
 * @property integer $condition
 */
class Sales extends ActiveRecord
{
	static $user;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales}}';
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
     * Finds sale by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
    }


    /**
     * Finds sale by emei
     *
     * @param string $emei
     * @return static|null
     */
    public static function findByEmei($emei)
    {
        return self::findOne(['emei1' => $emei]);
    }


    /**
     * Finds sale by emei
     *
     * @param string $emei
     * @return static|null
     */
    public static function getEmei1($emei)
    {
        return self::findOne(['emei1' => $emei]);
    }


    /**
     * Finds sale by emei
     *
     * @param string $emei
     * @return static|null
     */
    public static function getEmei2($emei)
    {
        return self::findOne(['emei2' => $emei]);
    }


    /**
     * Finds sale by emei
     *
     * @param string $emei
     * @return static|null
     */
    public static function getSerial($serial)
    {
        return self::findOne(['serial' => $serial]);
    }


    /**
     * Finds sale by user_id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findByUserId($id)
    {
        return self::findOne(['user_id' => $id, 'condition' => 10]);
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
	public function getProducts()
	{
		return $this->hasOne(Products::className(), ['id' => 'model']);
	}


    /**
     * @inheritdoc
     */
    public static function countUserSales($id)
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
				->andwhere(['>=', 'condition', 10])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function countAllApproved()
    {
        return self::find()
				->where(['>=', 'condition', 10])
				->count();
    }


    /**
     * @inheritdoc
     */
    public static function getPointsForUser($id)
    {
        $sql = self::find()
				->where(['=', 'user_id', $id])
				->andwhere(['>=', 'condition', 10])
				->all();
		$total = 0;
		foreach( $sql as $sale ) {
			$total += $sale->price;
		}
		return $total;
    }


    /**
     * Change condition
     */
    public function changeStatus($condition)
	{

		if( $this->condition <= 1 && $condition == 10 ) {
			$profile = Profile::findById($this->user_id);
			$profile->changeScores($this->price);
		}
		if( $this->condition == 10 && $condition == 0 ) {
			$profile = Profile::findById($this->user_id);
			$profile->changeScores($this->price, true);
		}

		$this->condition = $condition;

		if( $this->save() ) {
			Yii::$app->session->setFlash('success', 'Продажа одобрена.');
			return true;
		} else {
			Yii::$app->session->setFlash('error', 'Продажа отклонена.');
			return null;
		}
	}


    /**
     * Change condition
     */
    public function toArchive()
	{
		$this->condition = 20;

		if( $this->save() ) {
			return true;
		} else {
			return false;
		}
	}


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img' => 'Чек',
            'model' => 'Модель устройства',
            'emei1' => 'EMEI',
			'emei2' => 'EMEI',
			'serial' => 'Серийный номер',
			'user_id' => 'Продавец',
            'created_at' => 'Создано',
			'date' => 'Дата продажи',
            'condition' => 'Статус',
            'price' => 'Бонус',
        ];
		
    }



    /**
     * Finds sale by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function getExpandedById($id)
    {
        $sale = self::findOne(['id' => $id]);
		return self::expandSettings($sale);
    }


    /**
     * @inheritdoc
     */
    public static function getAllForUserArray($id)
    {
        $sales = self::find()
				->where(['=', 'user_id', $id])
				->all();
		$sort_sales = [];

		foreach ($sales as $sale) {
			$sort_sales[$sale->id] = self::expandSettings($sale);
		}

		return $sort_sales;
    }


    /**
	 * For admin dashboard
	 *  
     * @inheritdoc
     */
    public static function getUnverificatedArray()
    {

        $sales = self::find()
				->where(['=', 'condition', 1])
				->orderBy('id')
				->all();
		$sort_sales = [];

		foreach ($sales as $sale) {
			$sort_sales[$sale->id] = self::expandSettings($sale);
		}

		return $sort_sales;
    }


    /**
     * @inheritdoc
     */
    public static function getAllExpandedArray()
    {
        $sales = self::find()
				->orderBy('condition')
				->all();
		$sort_sales = [];

		foreach ($sales as $sale) {
			$sort_sales[$sale->id] = self::expandSettings($sale);
		}

		return $sort_sales;
    }


    /**
     * @inheritdoc
     */
    private static function expandSettings($sale)
    {
		$product = Products::findById($sale->model);
		if( !isset(self::$user) || self::$user->id != $sale->user_id ) {
			self::$user = User::findUserById($sale->user_id);
		}

		return [
			'model_id' => $sale->model,
			'model' => $product->name,
			'user_id' => $sale->user_id,
			'user_name' => self::$user->username,
			'date' => $sale->date,
			'price' => $sale->price,
			'condition' => $sale->condition,
		];
    }


}