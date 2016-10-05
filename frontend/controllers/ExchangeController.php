<?php
namespace frontend\controllers;

use Yii;
use common\models\Page;
use common\models\LoginForm;
use common\models\ProfileDetails;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\SignupComplete;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;

use \yii\web\ResponseEvent;
use common\models\Profile;
use common\models\User;
use console\models\Exchange;
use yii\filters\ContentNegotiator;
use yii\web\Response;


/**
 * Site controller
 */
class ExchangeController extends Controller
{
	/**
     * @inheritdoc
     */
public function behaviors()
{
    return [
        [
            'class' => 'yii\filters\ContentNegotiator',
            'only' => ['index'],  // in a controller
            // if in a module, use the following IDs for user actions
            // 'only' => ['user/view', 'user/index']
            'formats' => [
                'application/xml' => Response::FORMAT_XML,
            ],
            'languages' => [
                'en',
                'ru',
            ],
        ],
    ];
}

	public function actionIndex()
	{
		//$response = \Yii::$app->response;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
		//\Yii::$app->response->setDownloadHeaders('profile.xml');
		$profile = new Profile;
		//\Yii::$app->response->EVENT_AFTER_PREPARE = 'afterPrepare';
		\Yii::$app->response->data = $profile->getStudentsList();
		//\Yii::$app->response->content = str_replace('item', 'profile', \Yii::$app->response->content);

		//
		
		return \Yii::$app->response->send();
	}

}