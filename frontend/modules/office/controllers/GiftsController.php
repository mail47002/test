<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Gifts;
use common\models\Prizes;
use common\models\GiftsSearch;
use common\models\GiftsForm;
use common\models\UserMails;
use common\models\Taxonomy;
use common\models\User;
use common\models\RatingSections;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GiftsController implements the CRUD actions for Gifts model.
 */
class GiftsController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'archive', 'view', 'create', 'update', 'select', 'delete', 'proof', 'reject', 'issued', 'resurect'],
				'rules' => [
					[
						'actions' => ['index', 'create', 'update', 'delete', 'proof', 'reject', 'issued', 'resurect'],
						'allow' => true,
						'roles' => ['admin'],
					],
                    [
                        'actions' => ['archive', 'view', 'select'],
                        'allow' => true,
                        'roles' => ['seller'],
                    ],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

    /**
     * Lists all Gifts models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new GiftsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }


    /**
     * Lists all Sales models.
     * @return mixed
     */
    public function actionArchive()
    {
		$searchModel = new GiftsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, \Yii::$app->user->identity->id);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gifts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);

		if( \Yii::$app->user->identity->role < 36 ) {
			if( \Yii::$app->user->identity->id != $model->user_id ) {
				return $this->redirect(['index']);
			}
			$username = \Yii::$app->user->identity->username;
			$admin_mode = false;
		} else {
			$user = User::findUserById($model->user_id);
			$username = $user->username;
			$admin_mode = true;
		}

		if($model->model == 0) {
			$prizes = false;
		} else {
			$prizes = Prizes::findById($model->model);
		}

		return $this->render('view', [
			'model' => $model,
			'prizes' => $prizes,
			'username' => $username,
			'admin_mode' => $admin_mode,
		]);
    }

    /**
     * Select new Gifts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSelect($id)
    {
        $model = new GiftsForm();

        if ($model->load(Yii::$app->request->post())) {
			$model->id = $id;
			if($model->select()) {
				$mail = new UserMails;
				$user = User::findUserById(\Yii::$app->user->identity->id);
				$mail->sendAdminEmail('admin-gift', $user);
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

		$model->loadData($id);

		if($model->user_id != \Yii::$app->user->identity->id) {
			return $this->redirect(['archive']);
		}

		return $this->render('update', [
			'model' => $model,
			'taxonomy' => RatingSections::findById($model->taxonomy),
			'prizesList' => Prizes::getPrizesByIdArray($model->taxonomy),
		]);
    }


    /**
     * Deletes an existing Gifts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$this->findModel($id)->delete();
		Yii::$app->session->setFlash('success', 'Подарок удален.');
		return $this->redirect(['index']);
    }

    /**
     * Poof gift.
     *
     * @return mixed
     */
    public function actionProof($id)
    {
		$gift = $this->findModel($id);

		if($gift->changeStatus(10)) {
			$mail = new UserMails;
			$user = User::findUserById($gift->user_id);
			$mail->giftProofEmail($user);
		}

		return $this->redirect(['index']);
    }

    /**
     * Reject gift.
     *
     * @return mixed
     */
    public function actionReject($id)
    {
		$gift = $this->findModel($id);

		if($gift->changeStatus(0)) {
			$mail = new UserMails;
			$user = User::findUserById($gift->user_id);
			$mail->giftRejectEmail($user);
		}

		return $this->redirect(['index']);
    }

    /**
     * Reject gift.
     *
     * @return mixed
     */
    public function actionIssued($id)
    {
		$gift = $this->findModel($id);
		$gift->changeStatus(20);

		return $this->redirect(['index']);
    }

    /**
     * Resurect gift.
     *
     * @return mixed
     */
    public function actionResurect($id)
    {
		$gift = $this->findModel($id);
		$gift->changeStatus(77);

		return $this->redirect(['index']);
    }

    /**
     * Finds the Gifts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gifts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		if (($model = Gifts::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Запрошенная Вами страница не найдена.');
		}
    }
}
