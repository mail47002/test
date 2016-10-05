<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Sales;
use common\models\Gifts;
use common\models\User;
use common\models\Products;
use frontend\models\SaleRegisterForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;
use common\models\UserMails;

/**
 * Salese controller
 */
class SalesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'add', 'list'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'add', 'list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * User check permisions.
     *
     * @return mixed
     */
	private function checkAdmin()
	{
		if (\Yii::$app->user->identity->role < 36) {
			return $this->redirect('index.php?r=office%2Fdashboard%2Findex');
		}
	}

    /**
     * User check permisions.
     *
     * @return mixed
     */
	private function checkUser()
	{
		if (\Yii::$app->user->identity->role != 10 ) {
			return $this->redirect('index.php?r=office%2Fdashboard%2Findex');
		}
	}

    /**
     * Displays sales list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$id = \Yii::$app->user->identity->id;

		$model = Sales::getAllForUserArray($id);

		return $this->render('index', [
			'model' => $model,
			'total_gifts' => Gifts::getPointsForUser($id),
		]);
    }

    /**
     * Displays sale.
     *
     * @return mixed
     */
    public function actionView($id)
    {

		$model = Sales::findById($id);
		if(\Yii::$app->user->identity->id != $model->user_id && \Yii::$app->user->identity->role < 36) {
			return $this->actionIndex();
		}

		if( \Yii::$app->user->identity->id != $model->user_id ) {
			$admin_mode = true;
			$user = User::findUserById($model->user_id);
			$username = $user->username;
		} else {
			$admin_mode = false;
			$username = \Yii::$app->user->identity->username;
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
     * Add Sale.
     *
     * @return mixed
     */
    public function actionAdd()
    {
		$this->checkUser();

		$id = \Yii::$app->user->identity->id;

        $model = new SaleRegisterForm();
        if ($model->load(Yii::$app->request->post())) {
			$model->user_id = $id;
			$model->register();

			$mail = new UserMails;
			$user = User::findUserById($id);
			$mail->sendAdminEmail('admin-sale', $user);
	
		}

		return $this->render('add', [
			'model' => $model,
			'productsList' => Products::getAllArray(),
		]);

    }

    /**
     * Displays sale.
     *
     * @return mixed
     */
    public function actionList()
    {
		$this->checkAdmin();

		$model = Sales::getAllExpandedArray();

		return $this->render('list', [
			'model' => $model,
		]);
    }


    /**
     * Poof Sale.
     *
     * @return mixed
     */
    public function actionProof($id)
    {
		$this->checkAdmin();

		$sale = Sales::findById($id);

		if($sale->changeStatus(10)) {
			$user_id = \Yii::$app->user->identity->id;
			$mail = new UserMails;
			$user = User::findUserById($user_id);
			$mail->saleProofEmail($user);
		}

		return $this->actionList();
    }

    /**
     * Reject Sale.
     *
     * @return mixed
     */
    public function actionReject($id)
    {
		$this->checkAdmin();

		$sale = Sales::findById($id);

		if($sale->changeStatus(0)) {
			$user_id = \Yii::$app->user->identity->id;
			$mail = new UserMails;
			$user = User::findUserById($user_id);
			$mail->saleRejectEmail($user);
		}

		return $this->actionList();
    }

}