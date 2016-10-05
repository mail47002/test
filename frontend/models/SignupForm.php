<?php
namespace frontend\models;

use common\models\User;
use common\models\Profile;
use common\models\ProfileDetails;
use common\models\UserMails;
use yii\base\Model;
use yii\bootstrap\Alert;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
	// User
    public $username;
    public $email;
    public $password;
	public $repassword;
	// Profile
	public $firstname;
	public $middlename;
	public $lastname;
	public $district;
	public $city;
	public $phone;
    public $education;
    public $organization;
    public $organization_address;
	public $subdivision;
	public $position;
	public $category;
	public $offer;
	public $scores;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['username', 'email', 'password', 'repassword', 'firstname', 'middlename', 'lastname', 'district', 'city', 'phone', 'education', 'subdivision', 'position', 'category', 'organization', 'organization_address', 'offer'], 'required', 'message' => 'Поле "{attribute}" обязательно для заполнения'],

            [['username', 'firstname', 'middlename', 'lastname', 'email', 'password', 'city', 'organization', 'organization_address'], 'string', 'min' => 2, 'tooShort' => 'Не менее 2 символов'],

            [['username', 'firstname', 'middlename', 'lastname', 'email', 'password', 'city', 'organization', 'organization_address'], 'string', 'max' => 255, 'tooLong' => 'Не более 255 символов'],

            ['username', 'filter', 'filter' => 'trim'],
			['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message'=>'Только буквы литиницей, цифры, дефис, подчеркивание'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такое имя пользователя уже занято'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => 'Адрес почты должен быть заполнен правильно'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким e-mail уже существует'],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Не менее 8 символов'],

            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],

            ['phone', 'string', 'min' => 10, 'tooShort'=>'Не менее 10 цифр после +38, например 0675555555'],
            ['phone', 'string', 'max' => 10, 'tooLong'=>'Не более 10 цифр после +38, например 0675555555'],
            ['phone', 'match', 'pattern' => '/^\s*\d+\s*$/', 'message'=>'Только цифры'],

			['offer', 'required', 'requiredValue' => 1, 'message' => 'Мы не можем продолжить без Вашего согласия'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {

			// User
            $user = new User();
			$user->role = 1;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
				Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранены данные пользователя.');
				return null;
            }

			// Role:
			/*$auth = Yii::$app->authManager;
			$newRole = $auth->getRole('verification');
			$auth->assign($newRole, $user->getId());*/

			// Profile
            $profile = new Profile();
            $profile->id = $user->getId();
			//$profile->user_num = 'smp-' . $profile->id;
            $profile->firstname = $this->firstname;
            $profile->middlename = $this->middlename;
            $profile->lastname = $this->lastname;
            $profile->district = (int)$this->district;
            $profile->city = $this->city;
            $profile->phone = $this->phone;
			$profile->education = $this->education;
			$profile->organization = $this->organization;
			$profile->organization_address = $this->organization_address;
			$profile->subdivision = $this->subdivision;
            $profile->position = $this->position;
            $profile->category = $this->category;
			$profile->sdo_password = $this->passwordGenerator();
            if (!$profile->save()) {
				Yii::$app->session->setFlash('error', 'Произошла ошибка, не сохранен профиль пользователя.');
				return null;
            }

            return true;
        }


    }

    /**
     * Sends an email with a link, for registration.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if($user) {
            if(!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            } else {
				Yii::$app->session->setFlash('error', 'Ошибка кода безопасности.');
			}

            if($user->save()) {
				$mail = new UserMails;
				return $mail->signupEmail($user);
            } else {
				Yii::$app->session->setFlash('error', 'Ошибка при сохранении данных пользователя.');
			}
        } else {
			Yii::$app->session->setFlash('error', 'Пользователь не нейден.');
		}

        return false;
    }


    /**
     * Password generator
	 * Password that can be memorize
     *
     * @return string
     */
	private function passwordGenerator()
    {
		$vowel = array('y','e','u','i','o','a');
		$consonat = array('w','r','t','p','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
		$result = '';
		$variant = mt_rand(1,20);
		// Start character
		if( $variant > 9 ) {
			$first = 'vowel';
			$second = 'consonat';
		} else {
			$first = 'consonat';
			$second = 'vowel';
		}
		// Alternation of characters
		for($i = 0; $i < 8; $i+=2 ) {
			$in = mt_rand(0,count(${$first})-1);
			$result .= ${$first}[$in];
			// First to upper
			if($i==0) {
				$result = strtoupper($result);
			}
			$in = mt_rand(0,count(${$second})-1);
			$result .= ${$second}[$in];
		}
		// Write some digits in the end
		$result .= mt_rand(99,999);
		return $result;
	}




    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя (Логин)',
            'email' => 'E-mail',
			'password' => 'Пароль',
			'repassword' => 'Повторите пароль',
			'firstname' => 'Имя',
			'middlename' => 'Отчество',
			'lastname' => 'Фамилия',
			'district' => 'Область',
			'city' => 'Город/Населенный пункт',
			'phone' => 'Телефон',
            'education' => 'Образование',
            'subdivision' => 'Подразделение (сеть)',
			'position' => 'Должность',
            'category' => 'Категория',
			'organization' => 'Организация',
            'organization_address' => 'Адрес организации',
            'offer' => 'Согласен на обработку моих персональных данных.',
		];
	}
}