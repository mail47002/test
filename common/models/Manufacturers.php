<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;



class Manufacturers extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manufacturers}}';
    }

    /**
     * Finds manufacturer by id
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
    public static function getAllArray()
    {
        $sql = self::find()->all();
		foreach( $sql as $value ) {
			$manufacturers[$value->id] = $value->name;
		}
		return $manufacturers;
    }


}