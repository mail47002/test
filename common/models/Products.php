<?php

namespace common\models;

use common\models\Taxonomy;
use common\models\Manufacturers;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $excerpt
 * @property integer $cat
 * @property integer $manufacturer
 * @property string $url
 * @property string $img
 * @property integer $draft
 * @property integer $bonus
 */
class Products extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['name', 'description', 'excerpt', 'cat', 'manufacturer', 'url', 'img', 'draft', 'bonus'], 'required'],
            [['description'], 'string'],
            [['cat', 'manufacturer', 'draft', 'bonus'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['excerpt'], 'string', 'max' => 500],
            ['url', 'string', 'max' => 255],
        ];
    }*/


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
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * @inheritdoc
     */
    public static function getAllProducts()
    {
        $sql = self::find()
					->where(['=', 'draft', 0])
					->orderBy('manufacturer')
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
     * @inheritdoc
     */
	public function getTaxonomy()
	{
		return $this->hasOne(Taxonomy::className(), ['id' => 'cat']);
	}


    /**
     * @inheritdoc
     */
	public function getManufacturers()
	{
		return $this->hasOne(Manufacturers::className(), ['id' => 'manufacturer']);
	}


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'description' => 'Описание',
            'excerpt' => 'Цитата',
            'cat' => 'Категория',
            'manufacturer' => 'Производитель',
            'url' => 'Сайт производителя',
            'img' => 'IMG',
            'draft' => 'Черновик',
            'bonus' => 'Баллов за продажу',
        ];
    }
}
