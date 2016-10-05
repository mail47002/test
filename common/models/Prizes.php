<?php

namespace common\models;

use common\models\Taxonomy;
use common\models\RatingSections;
use common\models\Manufacturers;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;


/**
 * This is the model class for table "prizes".
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
 * @property integer $gift
 */
class Prizes extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%prizes}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['name', 'description', 'excerpt', 'cat', 'manufacturer', 'url', 'img', 'draft', 'gift'], 'required'],
            [['description'], 'string'],
            [['cat', 'manufacturer', 'draft', 'gift'], 'integer'],
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
    public static function getAllPrizes()
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
	public function getTaxonomy()
	{
		return $this->hasOne(Taxonomy::className(), ['id' => 'cat']);
	}


    /**
     * @inheritdoc
     */
	public function getSection()
	{
		return $this->hasOne(RatingSections::className(), ['id' => 'cat']);
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
    public static function getPrizesByIdArray($id)
    {
        $sql = self::find()
					->where(['=', 'cat', $id])
					->orderBy('manufacturer')
					->all();
		foreach($sql as $prize) {
			$prizes[$prize->id] = $prize->name;
		}
		return $prizes;
    }

    /**
     * @inheritdoc
     */
    public static function countPrizesByCat($id)
    {
        $sql = self::find()
					->where(['=', 'cat', $id])
					->count();
		return $sql;
    }


    /**
     * @inheritdoc
     */
    public static function getOneByCat($id)
    {
        $sql = self::find()
					->where(['=', 'cat', $id])
					->one();
		return $sql;
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
            'gift' => 'Эквивалент',
        ];
    }
}
