<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profile_details".
 *
 * @property integer $id
 * @property string $name
 * @property integer $implement
 */
class ProfileDetails extends \yii\db\ActiveRecord
{
	const ROOT_NAME = 'Родительский элемент';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['implement'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }


    /**
     * Finds profile detail by id
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
	public static function getParentsList()
	{
		// Выбираем только те категории, у которых есть дочерние категории
		$parents = self::find()
				->where(['=', 'implement', 0])
				->orderBy('id')
				->all();
		$array = ArrayHelper::map($parents, 'id', 'name');
		$array[0] = self::ROOT_NAME; 
		return $array;
	}

    /**
	 * Implement Name Static Edition
     * @inheritdoc
     */
	public static function getParentName($implement) {
		if( $implement != 0 ) {
			$parent = self::find()
				->where(['=', 'id', $implement])
				->one();
			return $parent->name;
		} else {
			return self::ROOT_NAME;
		}
	}


    /**
     * @inheritdoc
     */
	public static function getImplementedList($implement)
	{
		// Выбираем только те категории, у которых есть дочерние категории
		$parents = self::find()
				->where(['=', 'implement', $implement])
				->orderBy('id')
				->all();
		$array = ArrayHelper::map($parents, 'id', 'name');
		return $array;
	}

    /**
	 * Get Name
     * @inheritdoc
     */
	public static function getItemName($id) {
		$profileItem = self::find()
				->where(['=', 'id', $id])
				->one();
		if($profileItem) {
			return $profileItem->name;
		} else {
			return $id;
		}

	}


    /**
	 * Implement Name
     * @inheritdoc
     */
	public function getImplementName() {
		if( $this->implement != 0 ) {
			$parent = $this->findOne($this->implement);
			return $parent->name;
		} else {
			return self::ROOT_NAME;
		}
	}


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Параметр',
            'implement' => 'Принадлежность',
        ];
    }
}
