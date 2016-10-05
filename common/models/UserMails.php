<?php
namespace common\models;

use yii\helpers\Html;

use common\models\Mail;
use common\models\User;
use common\models\Profile;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Post modify form
 */
class UserMails extends Model
{

    /**
     * Sends an email with a welcome massage.
     *
     * @return boolean whether the email was send
     */
    private function sendEmail($template, $mail, $to, $args)
    {
		$mail = Mail::findOneBySlug($mail);
		$args['mail'] = $mail->content;
		return \Yii::$app->mailer->compose(['html' => $template.'-html', 'text' => $template.'-text'], $args)
				->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->params['smpAcronym']])
				->setReplyTo([\Yii::$app->params['supportEmail'] => \Yii::$app->params['smpAcronym']])
				->setTo($to)
				->setSubject($mail->title)
				->send();
	}

    /**
     * Sends an email with to administrator.
     */
    public function sendAdminEmail($template, $user)
    {
		$to = User::findAdminEmails();
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('admin', $template, $to, $args);
	}

    /**
     * Sends an email with a welcome massage.
     */
    public function signupEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('signup', 'signup', $user->email, $args);
    }

    /**
     * Sends an email with a welcome massage.
     */
    public function proofEmail($user)
    {
		// SDO login data
		$profile = Profile::findById($user->id);
		$sdo_password = $profile->sdo_password;
		// Mail args
		$args = ['user' => $user, 'sdo_password' => $sdo_password];
		return $this->sendEmail('proof', 'user-proof', $user->email, $args);
    }

    /**
     * Sends an email with a welcome massage.
     */
    public function passwordEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('passwordResetToken', 'password', $user->email, $args);
    }


    /**
     * Sends an email with a welcome massage.
     */
    public function sdoSuccessEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'sdo-success', $user->email, $args);
    }


    /**
     * Sends an email with a welcome massage.
     */
    public function giftNewEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'new-gift', $user->email, $args);
    }

    /**
     * Sends an email with a welcome massage.
     */
    public function giftProofEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'gift-proof', $user->email, $args);
    }


    /**
     * Sends an email with a welcome massage.
     */
    public function giftRejectEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'gift-reject', $user->email, $args);
    }


    /**
     * Sends an email with a welcome massage.
     */
    public function saleProofEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'sale-proof', $user->email, $args);
    }


    /**
     * Sends an email with a welcome massage.
     */
    public function saleRejectEmail($user)
    {
		// Mail args
		$args = ['user' => $user];
		return $this->sendEmail('common', 'sale-reject', $user->email, $args);
    }
}