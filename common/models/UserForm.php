<?php
namespace common\models;

use common\models\Profile;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\base\NotSupportedException;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class ProfileForm extends Model
{
    public $id;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
		return [
			['role', 'required'],
		];
    }


   /**
	 * Register profile.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function register()
	{
		if ($this->validate()) {

			// User
			$user = User::findById($this->id);

			$user->id = $user->id;

			// Save
			if ($user->save(false)) {
				Yii::$app->session->setFlash('success', 'Информация о роли пользователя обновлена.');
			} else {
				Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных.');
			}
			return true;
		}
	}


    /**
     * Load Data
     *
     * @return array
     */
	public function loadData()
	{
		$user = User::findById($this->id);

		$this->role = $user->role;
	}


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'roles' => 'Роль пользователя',
		];
	}

}