<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Taxonomy;
use common\models\Manufacturers;


class Products extends ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * Finds product by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds product by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findCompleteById($id)
    {
        $product = self::findOne(['id' => $id]);
		$category = Taxonomy::findById($product->cat);
		$product->cat = $category->name;
		$manufacturer = Manufacturers::findById($product->manufacturer);
		$product->manufacturer = $manufacturer->name;
		
		return $product;
    }

    /**
     * @inheritdoc
     */
    public static function getAll()
    {
        $sql = self::find()->all();

		return $sql;
    }

    /**
     * @inheritdoc
     */
    public static function getAllBonuses()
    {
        $sql = self::find()
					->where(['=', 'bonus_show', 10])
					->orderBy('manufacturer')
					->all();
		return $sql;
    }

    /**
     * @inheritdoc
     */
    public static function getAllGifts()
    {
        $sql = self::find()
					->where(['=', 'gift_show', 10])
					->all();
		return $sql;
    }

    /**
     * @inheritdoc
     */
    public static function getAllArray()
    {
        $sql = self::find()->all();
		foreach( $sql as $value ) {
			$products[$value->id] = $value->name;
		}
		return $products;
    }

    /**
     * Change product status
     */
    public function changeBonusStatus($status = true) {
		if($status) {
			$this->bonus_show = 10;
		} else {
			$this->bonus_show = 0;
		}
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Отображение бонуса обновлено.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных.');
		}
	}

    /**
     * Change product status
     */
    public function changeGiftStatus($status = true) {
		if($status) {
			$this->gift_show = 10;
		} else {
			$this->gift_show = 0;
		}
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Отображение подарка обновлено.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных.');
		}
	}
}