<?php
namespace common\models;

use common\models\Roles;
use common\models\Taxonomy;
use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

class Post extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
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
     * Finds post by id
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
     * Finds post by id
     *
     * @param integer $id
     * @return static|null
     */
    public static function findCompleteById($id)
    {
        $post = self::findOne(['id' => $id]);
		$tax = Taxonomy::findById($post->category);
		$post->category = $tax->name;
		$post->created_at = $post->created_at;

		return $post;
    }


    /**
     * @inheritdoc
     */
	public function getTaxonomy()
	{
		return $this->hasOne(Taxonomy::className(), ['id' => 'id']);
	}

	
	/**
     * @inheritdoc
     */
    public static function getTaxId($id)
    {
        $post = self::findOne(['id' => $id]);
		return $post->category;
    }


    /**
     * @inheritdoc
     */
    public static function getAll()
    {
        return self::find()->all();
    }















    /**
     * @inheritdoc
     * @param string $tax_name
     */
    public static function getArchive($tax_name, $limit = 10, $tax_id = false)
    {
		$tax = Taxonomy::findBySlug($tax_name);

		$post = self::find()
					->where(['=', 'category', $tax->id])
					->limit($limit)
					->all();

		foreach( $post as $value ) {
			if( !$tax_id ) {
				$value->category = $tax->name;
			}
		}
		return $post;
    }


    /** /////////////////////////////////
     * @inheritdoc
     * @param string $tax_name
     */
    public static function getArchiveById($tax, $limit = 10)
    {
		return self::find()
					->where(['=', 'category', $tax])
					->limit($limit)
					->all();
    }


    /**
     * @inheritdoc
     * @param string $tax_name
     */
    public static function getSubArchive($tax_name, $limit = 10, $tax_id = false)
    {
		$tax = Taxonomy::getChildrensId($tax_name);

		$post = self::find()
					->where(['=', 'category', $tax])
					->limit($limit)
					->all();

		foreach( $post as $value ) {
			if( !$tax_id ) {
				$value->category = $tax->name;
			}
		}
		return $post;
    }


    /**
     * Change post status
     */
    public function changeStatus($status = true) {
		if($status) {
			$this->draft = 1;
		} else {
			$this->draft = 0;
		}
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Отображение записи обновлено.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных.');
		}
	}


    /**
	 * Get role data
     * @inheritdoc
     */
	public static function getRole($id) {
		return  Roles::findById($id);
	}


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'slug' => 'Ярлык',
            'draft' => 'Черновик',
            'category' => 'Категория',
			'prohibition' => 'Назначение',
            'img' => 'IMG',
            'title' => 'Заголовок',
            'created_at' => 'Создано',
            'excerpt' => 'Цитата',
            'content' => 'Контент',
			
        ];
    }
}