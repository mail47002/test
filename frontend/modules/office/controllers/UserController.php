<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\UserMails;
use common\models\Sales;
use common\models\Gifts;
use common\models\User;
use common\models\Profile;
use common\models\ProfileDetails;
use common\models\ProfileForm;
use common\models\Roles;
use common\models\RatingSections;
use common\models\UserSearch;
use common\models\PasswordChangeForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'rating', 'view', 'viewinfo', 'create', 'update', 'profile', 'changeprofile', 'delete', 'turnon', 'turnoff', 'password'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'profile', 'delete', 'turnon', 'turnoff'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'actions' => ['rating', 'viewinfo', 'changeprofile', 'password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'study' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Change user role.
     *
     * @return mixed
     */
	private function changeUserRole($id,$role)
	{
		$user = User::findUserById($id);
		if( $user->role != $role ) {
			$user->changeRole($role);
		}
	}

    /**
     * Change user role.
     *
     * @return mixed
     */
	private function changeUserStatus($id,$status = false)
	{
		$user = User::findUserById($id);
		if( $user->status != $status ) {
			$user->changeStatus($status);
		}
	}


    /**
     * Render update profile page.
     *
     * @return mixed
     */
    private function renderUpdatePage($id, $admin_mode = false)
    {
		if(\Yii::$app->user->identity->role < 36) {
			if(\Yii::$app->user->identity->id != $id) {
				$id = \Yii::$app->user->identity->id;
			}
		}

		$model = new ProfileForm();
		$model->id = $id;
		//var_dump($model->birthday);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->register();
		}

		$model->loadData();
		return $this->render('profile', [
			'model' => $model,
				'genderList' => ProfileDetails::getImplementedList(6),
				'districtList' => ProfileDetails::getImplementedList(1),
				'educationList' => ProfileDetails::getImplementedList(2),
				'subdivisionList' => ProfileDetails::getImplementedList(4),
				'positionList' => ProfileDetails::getImplementedList(3),
				'categoryList' => ProfileDetails::getImplementedList(5),
			'user' => User::findIdentity($id),
			'admin_mode' => $admin_mode,
		]);
    }

    /**
     * Render profile details.
     *
     * @return mixed
     */
    private function renderViewPage($id, $admin_mode = false)
    {
		$user = $this->findModel($id);
		$args['user'] = $user;
		$args['profile'] = Profile::findOne($id);
		$args['admin_mode'] = $admin_mode;
		if( $user->role == 10 ) {
			$args['count_gifts'] = Gifts::countApproved($id);
			$args['count_bonuses'] = Sales::countApproved($id);
			$args['total_gifts'] = Gifts::getPointsForUser($id);
			$args['total_bonuses'] = Sales::getPointsForUser($id);
		}
        return $this->render('view', $args);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'details');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'subdivisionList' => ProfileDetails::getImplementedList(4),
			'rolesList' => Roles::getAllList(\Yii::$app->user->identity->role),
        ]);
    }


    /**
     * Lists top 23 User models.
     * @return mixed
     */
    public function actionRating()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'rating');
		$dataProvider->pagination->pageSize=100;
		$dataProvider->totalCount=100;
		$apportionment = RatingSections::getApportionment();

        return $this->render('rating', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'apportionment' => $apportionment,
        ]);
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
	{
        return $this->renderViewPage($id, true);
    }


    /**
     * Displays a single User model.
     * @return mixed
     */
    public function actionViewinfo()
    {
        return $this->renderViewPage(\Yii::$app->user->identity->id);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->changeRole(Yii::$app->request->post()['User']['role']);
			Yii::$app->session->setFlash('success', 'Информация о роли пользователя обновлена.');
            return $this->actionIndex();
        } else {
            return $this->render('update', [
                'model' => $model,
				'rolesList' => Roles::getAllList(\Yii::$app->user->identity->role),
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChangeprofile()
    {
		return $this->renderUpdatePage(\Yii::$app->user->identity->id);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @param integer $id
     * @return mixed
     */
    public function actionProfile($id)
    {
		return $this->renderUpdatePage($id,true);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$sales = Sales::countUserSales($id);
		$gifts = Gifts::countUserGifts($id);

		if($sales == 0 && $gifts == 0 ) {
			/* Add check gifts and sales */
			$this->findModel($id)->delete();
			Profile::findOne($id)->delete();
			Yii::$app->session->setFlash('success', 'Пользователь удален.');
		} else {
			Yii::$app->session->setFlash('error', 'Сначала нужно удалить продажи и подарки пользователя.');
		}

        return $this->redirect(['index']);
    }

    /**
     * User proof action.
     *
     * @return mixed
     */
    public function actionProof($id)
    {
		$user = $this->findModel($id);
		if( $user->role == 4 ) {
			$user->changeRole(5);
			//$userMails = new UserMails;
			//$userMails->proofEmail($user);
		}

        return $this->redirect(['index']);
    }

    /**
     * Turn Off User.
     *
     * @return mixed
     */
    public function actionTurnoff($id)
    {
		$this->changeUserStatus($id,false);

        return $this->redirect(['index']);
    }

    /**
     * Turn On User.
     *
     * @return mixed
     */
    public function actionTurnon($id)
    {
		$this->changeUserStatus($id,true);

        return $this->redirect(['index']);
    }

    /**
     * Study.
     *
     * @return mixed
     */
    public function actionStudy()
    {
		$users = User::findAllSellers();
		foreach($users as $user) {
			if($user->role == 10) {
				$this->changeUserRole($user->id,6);
			}
		}

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionPassword()
    {
		$model = new PasswordChangeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$id = \Yii::$app->user->identity->id;
			$user = User::findIdentity($id);
			$user->setPassword($model->password);
			if ( $user->save(false) ) {
				return $this->actionIndex();
			}
		}

		return $this->render('password', [
			'model' => $model,
		]);
    }
}
