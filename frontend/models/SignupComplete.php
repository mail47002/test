<?php
namespace frontend\models;

use common\models\User;
use common\models\UserMails;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class SignupComplete extends Model
{
    public $password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Signup token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong signup token token.');
        }

    }

    /**
     * Finish Activation.
     *
     * @return boolean if password was reset.
     */
    public function finishActivation()
    {
        $user = $this->_user;
        $user->changeRole(4);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    /**
     * Sends an email with a link, for registration.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
		$mail = new UserMails;
		$mail->sendAdminEmail('admin-user', $this->_user);
    }
}
