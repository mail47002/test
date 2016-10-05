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
    public $img;
//    public $user_num;
    public $firstname;
    public $middlename;
    public $lastname;
    public $birthday;
    public $gender;
    public $district;
    public $city;
    public $phone;
    public $education;
    public $work_expiriance;
    public $company_expiriance;
    public $subdivision;
//    public $subdivision_id;
    public $position;
//    public $position_id;
    public $organization;
    public $organization_address;
    public $category;
//    public $category_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
		return [

            [['firstname', 'middlename', 'lastname', 'district', 'city', 'phone', 'education', 'subdivision', 'position', 'category', 'organization', 'organization_address'], 'required', 'message' => 'Поле "{attribute}" обязательно для заполнения'],

            [['firstname', 'middlename', 'lastname', 'city', 'organization', 'organization_address'], 'string', 'min' => 2, 'tooShort' => 'Не менее 2 символов'],

            [['firstname', 'middlename', 'lastname', 'city', 'organization', 'organization_address'], 'string', 'max' => 255, 'tooLong' => 'Не более 255 символов'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => 'Адрес почты должен быть заполнен правильно'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким e-mail уже существует'],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Не менее 8 символов'],

            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],

            ['phone', 'string', 'min' => 10, 'tooShort'=>'Не менее 10 цифр после +38, например 0675555555'],
            ['phone', 'string', 'max' => 10, 'tooLong'=>'Не более 10 цифр после +38, например 0675555555'],
            ['phone', 'match', 'pattern' => '/^\s*\d+\s*$/', 'message'=>'Только цифры'],

			['img', 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

			['birthday', 'default', 'value' => 0],

			['gender', 'string'],

			[['work_expiriance', 'company_expiriance'], 'integer', 'max' => 999, 'message' => '{attribute} - укажите число месяцев', 'tooBig' => 'Число не более 999'],
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

			// Data manipulation
			$file = UploadedFile::getInstance($this, 'img');
			if( is_object($file) ) {
				$dir = Yii::getAlias('uploads/profiles/');
				$file_name = 'profile_' . $this->id;
				$uploaded = $file->saveAs( $dir . $file_name . '.' . $file->extension);
				$$profile->img = $file_name . '.' . $file->extension;
			}

			// Profile
			$profile = Profile::findById($this->id);

			$profile->id = $this->id;
			$profile->img = $this->img;
			//$profile->user_num = $this->user_num;
			$profile->firstname = $this->firstname;
			$profile->middlename = $this->middlename;
			$profile->lastname = $this->lastname;
			$profile->birthday = $this->birthday;
			$profile->gender = $this->gender;
			$profile->district = $this->district;
			$profile->city = $this->city;
			$profile->phone = $this->phone;
			$profile->education = $this->education;
			$profile->work_expiriance = $this->work_expiriance;
			$profile->company_expiriance = $this->company_expiriance;
			$profile->subdivision = $this->subdivision;
			//$profile->subdivision_id = $this->subdivision_id;
			$profile->position = $this->position;
			//$profile->position_id = $this->position_id;
			$profile->organization = $this->organization;
			$profile->organization_address = $this->organization_address;
			$profile->category = $this->category;
			//$profile->category_id = $this->category_id;

			// Save
			if ($profile->save()) {
				Yii::$app->session->setFlash('success', 'Информация профиля пользователя обновлена.');
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
		$profile = Profile::findById($this->id);

		$this->img = $profile->img;
		//$this->user_num = $profile->user_num;
		$this->firstname = $profile->firstname;
		$this->middlename = $profile->middlename;
		$this->lastname = $profile->lastname;
		$this->birthday = $profile->birthday;
		$this->gender = $profile->gender;
		$this->district = $profile->district;
		$this->city = $profile->city;
		$this->phone = $profile->phone;
		$this->education = $profile->education;
		$this->work_expiriance = $profile->work_expiriance;
		$this->company_expiriance = $profile->company_expiriance;
		$this->subdivision = $profile->subdivision;
		//$this->subdivision_id = $profile->subdivision_id;
		$this->position = $profile->position;
		//$this->position_id = $profile->position_id;
		$this->organization = $profile->organization;
		$this->organization_address = $profile->organization_address;
		$this->category = $profile->category;
		//$this->category_id = $profile->category_id;
	}


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'user_num' => 'Табельный номер',
            'img' => 'Аватар',
			'firstname' => 'Имя',
			'middlename' => 'Отчество',
			'lastname' => 'Фамилия',
            'birthday' => 'Дата рождения',
            'gender' => 'Пол',
			'district' => 'Область',
			'city' => 'Город/Населенный пункт',
			'phone' => 'Телефон',
            'education' => 'Образование',
            'work_expiriance' => 'Стаж работы (мес.)',
            'company_expiriance' => 'Стаж работы в компании (мес.)',
            'subdivision' => 'Подразделение (сеть)',
            'subdivision_id' => 'Код подразделения',
			'position' => 'Должность',
            'position_id' => 'Код должности',
			'organization' => 'Организация (Название компании)',
            'organization_address' => 'Адрес организации',
            'category' => 'Категория',
            'category_id' => 'Код категории',
            'scores' => 'Набрано баллов',
		];
	}

}