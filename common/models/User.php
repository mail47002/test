<?php
namespace common\models;

use Yii;
use common\models\Roles;
use common\models\Profile;
use common\models\ProfileDetails;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
use developeruz\db_rbac\interfaces\UserRbacInterface;

class User extends ActiveRecord implements IdentityInterface, UserRbacInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

	const ROLE_VERIFICATION = 'verification';
	const ROLE_PROOF = 'proof';
	const ROLE_SDO = 'sdo';
	const ROLE_STUDY = 'study';
	const ROLE_SELLER = 'seller';
	const ROLE_SENIOR_SELLER = 'senior_seller';
	const ROLE_EDITOR = 'editor';
	const ROLE_ANALYST = 'analyst';
	const ROLE_ADMIN = 'admin';
	const ROLE_GOD_MODE = 'god_mode';

	const ROLE_VERIFICATION_ID = 1;
	const ROLE_PROOF_ID = 4;
	const ROLE_SDO_ID = 5;
	const ROLE_STUDY_ID = 6;
	const ROLE_SELLER_ID = 10;
	const ROLE_SENIOR_SELLER_ID = 12;
	const ROLE_EDITOR_ID = 16;
	const ROLE_ANALYST_ID = 21;
	const ROLE_ADMIN_ID = 36;
	const ROLE_GOD_MODE_ID = 77;

    /**
     * @inheritdoc
     */
	public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert) {
            $auth = Yii::$app->authManager;
			$roles = Roles::findById($this->role);
            $role = $auth->getRole($roles->slug);
            $auth->assign($role, $this->id);
        }

        Yii::$app->authManager->invalidateCache();
    }

    /**
     * @inheritdoc
     */
    public function getUserName()
    {
       return $this->username;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
					ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }


    /**
     * @inheritdoc
     */
	public function getProfile()
	{
		return $this->hasOne(Profile::className(), ['id' => 'id']);
	}


    /**
     * Change user role
     */
    public static function findAllSellers() {
		return self::find()
				->where(['=', 'role', 10])
				->andwhere(['=','status', 10])
				->all();
	}


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findUserById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds admins emails
     *
     * @return array|null
     */
    public static function findAdminEmails()
    {
        $users = self::find()
				->where(['=', 'role', 36])
				->andwhere(['=','status',self::STATUS_ACTIVE])
				->all();
		$sort_users = '';
		foreach ($users as $user) {
			$sort_users[] = $user->email;
		}
		return $sort_users;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
	 * Get role data
     * @inheritdoc
     */
	public static function getRole($id) {
		return Roles::findById($id);
	}


    /**
	 * Get subdivision data
     * @inheritdoc
     */
	public static function getSubdivision($id) {
		return ProfileDetails::findById($id);
	}

    /**
     * Change user role
     */
    public function changeRole($role) {
        $this->role = $role;
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Роль пользователя обновлена.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных роли.');
		}
	}

    /**
     * Change user role
     */
    public function changeRoleSilence($role) {
        $this->role = $role;
		if ($this->save()) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * Change user role
     */
    public function changeStatus($status = true) {
		if($status) {
			$this->status = 10;
		} else {
			$this->status = 0;
		}
		if ($this->save()) {
			Yii::$app->session->setFlash('success', 'Статус пользователя обновлена.');
		} else {
			Yii::$app->session->setFlash('error', 'Возникла ошибка при сохранении данных статуса.');
		}
	}












    /**
     * @inheritdoc
     */
    public static function getSingleRoleArray($role)
    {

        $users = self::find()
				->where(['=', 'role', $role])
				->andwhere(['=','status',self::STATUS_ACTIVE])
				->orderBy('role')
				->all();
		$sort_users = [];
		foreach ($users as $user) {
			$sort_users[$user->id] = [
				'username' => $user->username,
				'email' => $user->email,
				'created_at' => $user->created_at,
			];
		}

		return $sort_users;
    }

    /**
     * @inheritdoc
     */
    public static function getAll($role, $id)
    {
        return self::find()
				->where(['<=', 'role', $role])
				->andwhere(['not in','id',[$id]])
				->orderBy('role')
				->all();
    }


    /**
     * @inheritdoc
     */
    public static function countUsers($role)
    {
        return self::find()
				->where(['=', 'role', $role])
				->count();
    }


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
		    'id' => 'ID',
            'username' => 'Имя пользователя (Логин)',
			'subdivision' => 'Сеть',
            'email' => 'Адрес почты',
			'created_at' => 'Регистрация',
			'updated_at' => 'Обновлен',
			'status' => 'Статус',
			'role' => 'Роль',
			'scores' => 'Баллы',
		];
	}
}