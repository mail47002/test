<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Sales;
use common\models\SalesSearch;
use common\models\SalesForm;
use common\models\UserMails;
use common\models\Gifts;
use common\models\User;
use common\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SalesController implements the CRUD actions for Sales model.
 */
class SalesController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['archive', 'index', 'view', 'create', 'delete', 'proof', 'reject'],
				'rules' => [
					[
						'actions' => ['index', 'delete', 'proof', 'reject'],
						'allow' => true,
						'roles' => ['admin'],
					],
					[
						'actions' => ['archive', 'view', 'create'],
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
	 * Lists all Sales models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new SalesSearch();
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
		$searchModel = new SalesSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, \Yii::$app->user->identity->id);

		return $this->render('archive', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Sales model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		if( \Yii::$app->user->identity->role < 36 ) {
			if( \Yii::$app->user->identity->id != $model->user_id ) {
				return $this->redirect(['archive']);
			}
			$username = \Yii::$app->user->identity->username;
			$admin_mode = false;
		} else {
			$user = User::findUserById($model->user_id);
			$username = $user->username;
			$admin_mode = true;
		}

		$product = Products::findById($model->model);

		return $this->render('view', [
			'model' => $model,
			'product' => $product,
			'username' => $username,
			'admin_mode' => $admin_mode,
		]);
	}

	/**
	 * Creates a new Sales model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new SalesForm();
		if ($model->load(Yii::$app->request->post())) {
			$model->user_id = \Yii::$app->user->identity->id;
			if($model->register()) {

				$mail = new UserMails;
				$user = User::findUserById(\Yii::$app->user->identity->id);
				$mail->sendAdminEmail('admin-sale', $user);

				$sale = Sales::findByEmei($model->emei1);
				return $this->actionView($sale->id);
			}
		}

		return $this->render('create', [
			'model' => $model,
			'productsList' => Products::getAllArray(),
		]);
	}


	/**
	 * Deletes an existing Sales model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		Yii::$app->session->setFlash('success', 'Продажа удалена.');
		return $this->redirect(['index']);
	}


	/**
	 * Poof Sale.
	 *
	 * @return mixed
	 */
	public function actionProof($id)
	{
		$sale = Sales::findById($id);
		
		if($sale->changeStatus(10)) {
			$mail = new UserMails;
			$user = User::findUserById($sale->user_id);
			$mail->saleProofEmail($user);
		}

		return $this->redirect(['index']);
	}

	/**
	 * Reject Sale.
	 *
	 * @return mixed
	 */
	public function actionReject($id)
	{
		$sale = Sales::findById($id);

		if($sale->changeStatus(0)) {
			$mail = new UserMails;
			$user = User::findUserById($sale->user_id);
			$mail->saleRejectEmail($user);
		}

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Sales model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Sales the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Sales::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Запрошенная Вами страница не найдена.');
		}
	}
}
