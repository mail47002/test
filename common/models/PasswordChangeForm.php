<?php
namespace common\models;

use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class PasswordChangeForm extends Model
{
    public $password;
    public $repassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
			['password', 'string', 'max' => 255],

            ['repassword', 'required'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],
        ];
    }


    /**
     * Translation
     *
     * @return array
     */
	public function attributeLabels()
    {
        return [
			'password' => 'Новый пароль',
			'repassword' => 'Повторите пароль',
		];
	}
}
