<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mail".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $content
 */
class Mail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'content'], 'required'],
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
            'title' => 'Заголовок',
            'content' => 'Текст сообщения',
        ];
    }
}
