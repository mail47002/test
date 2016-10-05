<?php

namespace frontend\modules\office\controllers;

use Yii;

use common\models\Post;
use common\models\Roles;
use common\models\Sales;
use common\models\SalesSearch;
use common\models\Gifts;
use common\models\GiftsSearch;
use common\models\User;
use common\models\UserSearch;
use common\models\Profile;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;


/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

	/**
	 * Displays dashboard.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$role_id = \Yii::$app->user->identity->role;
		$user_id = \Yii::$app->user->identity->id;
		$role = Roles::findById($role_id);

		$args['role'] = $role;
		$args['title'] = 'Добро пожаловать в СМП';
		$args['news'] = Post::getArchive('news');

		if( $role->id >= 36 ) {
			// Admin notifications
			$usersSearchModel = new UserSearch();
			$usersSearchModel->role = 4;
			$usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
			$usersDataProvider->pagination->pageSize=100;
			$usersDataProvider->totalCount=100;
			$args['usersDataProvider'] = $usersDataProvider;

			$salesSearchModel = new SalesSearch();
			$salesSearchModel->condition = 1;
			$salesDataProvider = $salesSearchModel->search(Yii::$app->request->queryParams);
			$salesDataProvider->pagination->pageSize=100;
			$salesDataProvider->totalCount=100;
			$args['salesDataProvider'] = $salesDataProvider;

			$giftsSearchModel = new GiftsSearch();
			$giftsSearchModel->condition = 1;
			$giftsDataProvider = $giftsSearchModel->search(Yii::$app->request->queryParams);
			$giftsDataProvider->pagination->pageSize=100;
			$giftsDataProvider->totalCount=100;
			$args['giftsDataProvider'] = $giftsDataProvider;

			$selectedGiftsSearchModel = new GiftsSearch();
			$selectedGiftsSearchModel->condition = 5;
			$selectedGiftsDataProvider = $selectedGiftsSearchModel->search(Yii::$app->request->queryParams);
			$selectedGiftsDataProvider->pagination->pageSize=100;
			$selectedGiftsDataProvider->totalCount=100;
			$args['selectedGiftsDataProvider'] = $selectedGiftsDataProvider;

		}
		if( $role->id > 16 ) {
			// Stuff statistic
			$args['users_sellers'] = User::countUsers(10);
			$args['users_study'] = User::countUsers(6);
			$args['total_sales'] = Sales::countAllApproved();
			$args['total_gifts'] = Gifts::countAllApproved();
		}
		if( $role->id == 10 ) {
			// User statistic
			$args['count_gifts'] = Gifts::countApproved($user_id);
			$args['count_bonuses'] = Sales::countApproved($user_id);
			$args['total_gifts'] = Gifts::getPointsForUser($user_id);
			$args['total_bonuses'] = Sales::getPointsForUser($user_id);

			$giftsSearchModel = new GiftsSearch();
			$giftsSearchModel->condition = 1;
			$giftsSearchModel->user_id = $user_id; 
			$giftsDataProvider = $giftsSearchModel->search(Yii::$app->request->queryParams);
			$giftsDataProvider->pagination->pageSize=10;
			$giftsDataProvider->totalCount=10;
			$args['giftsDataProvider'] = $giftsDataProvider;

			$selectedGiftsSearchModel = new GiftsSearch();
			$selectedGiftsSearchModel->condition = 5;
			$selectedGiftsSearchModel->user_id = $user_id;
			$selectedGiftsDataProvider = $selectedGiftsSearchModel->search(Yii::$app->request->queryParams);
			$selectedGiftsDataProvider->pagination->pageSize=100;
			$selectedGiftsDataProvider->totalCount=100;
			$args['selectedGiftsDataProvider'] = $selectedGiftsDataProvider;
		}
		if( $role->id == 6 ) {
			// SDO login data
			$profile = Profile::findById($user_id);
			// $args['sdo_password'] = $profile->sdo_password;
			$args['username'] = \Yii::$app->user->identity->username;
			$args['userid'] = \Yii::$app->user->identity->id;
		}
		
		return $this->render('index', $args);
	}

}