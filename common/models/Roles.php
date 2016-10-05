<?php
namespace common\models;

use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\base\Model;
use Yii;

/**
 * Sales model
 *
 * @property integer $id
 * @property string $name
 * @property string $description

 */
class Roles extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }


    /**
     * Finds role by id
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
	public static function getAllList($role)
	{
        $roles = self::find()
				->where(['<=', 'id', $role])
				->all();
		$array = ArrayHelper::map($roles, 'id', 'name');
		return $array;
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
     */
/*    public static function getAll($role)
    {
        $roles = self::find()
				->where(['<=', 'id', $role])
				->all();

		foreach ($roles as $role) {
			$sort_roles[$role->id] = $role;
		}

		return $sort_roles;
    }*/

    /**
     * @inheritdoc
     */
    /*public static function getAllList($role)
    {
        $roles = self::find()
				->where(['<=', 'id', $role])
				->all();

		foreach ($roles as $role) {
			$sort_roles[$role->id] = $role->name;
		}

		return $sort_roles;
    }*/



    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'name' => 'Роль',
            'description' => 'Описание',
		];
	}

}