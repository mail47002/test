<?php

namespace common\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $draft
 * @property string $slug
 * @property string $title
 * @property integer $sort
 * @property integer $created_at
 * @property string $img
 * @property string $content
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
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
            [['slug', 'title', 'content'], 'required'],
            ['created_at', 'integer'],
            ['content', 'string'],
            ['title', 'string', 'max' => 255],

			['slug', 'string', 'max' => 150],
			['slug', 'match', 'pattern' => '/^[0-9a-zA-Z\-]+$/', 'message' => 'Только латиница.'],
			['slug', 'unique', 'targetClass' => '\common\models\Mail', 'message' => 'Должно быть уникальным. В идеале заголовок транслитом.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findOneBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ярлык',
            'title' => 'Заглоовок',
            'created_at' => 'Создано',
            'content' => 'Контент',
        ];
    }
}