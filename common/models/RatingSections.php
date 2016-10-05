<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rating_sections".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property integer $points
 */
class RatingSections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rating_sections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'points'], 'required', 'message' => 'Поле "{attribute}" обязательно для заполнения'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Не более 255 символов'],
            ['slug', 'string', 'max' => 100, 'tooLong' => 'Не более 100 символов'],
			['slug', 'match', 'pattern' => '/^[0-9a-zA-Z\-]+$/', 'message' => 'Только латиница.'],
			['slug', 'unique', 'targetClass' => '\common\models\RatingSections', 'message' => 'Должно быть уникальным в пределах блоков рейтинга. В идеале заголовок транслитом.'],
            ['points', 'integer', 'message' => '{attribute} - укажите число'],
            ['description', 'string'],
        ];
    }


    /**
     * Finds Rating section by id
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
    public static function getAll()
    {
        return self::find()
				->orderBy('id')
				->all();
    }


    /**
     * @inheritdoc
     */
    public static function getAllArray($all = false)
    {

        $sql = self::getAll();
		$sections = [];

		foreach( $sql as $value ) {
			if( !$all ) {
				$sections[$value->id] = $value->name;
			} else {
				$sections[$value->id] = [
					'name' => $value->name,
					'slug' => $value->slug,
					'points' => $value->points,
					'description' => $value->description,
				];
			}
		}
		return $sections;
    }


    /**
     * Count total points
     *
     * @param integer $id
     * @return static|null
     */
    public static function countTotalPoints()
    {

        $sql = self::getAll();
		$counter = 0;

		foreach( $sql as $value ) {
			$counter += (int)$value->points;
		}
		return $counter;
    }


    /**
     * Count total points
     *
     * @param integer $id
     * @return static|null
     */
    public static function getApportionment()
    {

        $sql = self::getAll();
		$sections = [];

		foreach( $sql as $value ) {
			$result_set[$value->points] = $value->name;
			$sections[$value->id] = [
				'name' => $value->name,
				'slug' => $value->slug,
				'points' => $value->points,
			];
		}
		return $sections;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ярлык',
            'name' => 'Название',
            'description' => 'Описание',
            'points' => 'Призовых мест',
        ];
    }
}
