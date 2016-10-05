<?php
namespace frontend\modules\office\controllers;

use Yii;
use common\models\Sales;
use common\models\Gifts;
use common\models\User;
use common\models\Products;
use common\models\Category;
use common\models\Manufacturers;
use common\models\UserMails;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;


/**
 * Bonus controller
 */
class GiftsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'order', 'list'],
                'rules' => [
                    [
                        'actions' => ['index', 'order', 'list'],
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
     * Displays gifts list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$id = \Yii::$app->user->identity->id;

		$model = Gifts::getAllForUserArray($id);

		return $this->render('index', [
			'model' => $model,
		]);
    }


    /**
     * Add Sale.
     *
     * @return mixed
     */
    public function actionOrder($id)
    {
		$user_id = \Yii::$app->user->identity->id;

		$total_gifts = Gifts::getPointsForUser($user_id);
		$total_sales = Sales::getPointsForUser($user_id);
		$total = $total_sales - $total_gifts;
		$product = Products::findById($id);
		if( $product->gift > $total ) {
			Yii::$app->session->setFlash('error', 'Недостаточно баллов.');
		} else {
			$gift = new Gifts();
			$gift->registerNew($user_id, $product->id, $product->gift);

			$mail = new UserMails;
			$user = User::findUserById($user_id);
			$mail->sendAdminEmail('admin-gift', $user);
	
			Yii::$app->session->setFlash('success', 'Подарок зарегистрирован');
		}

		return $this->actionIndex();
    }

    /**
     * Displays sale.
     *
     * @return mixed
     */
    public function actionList()
    {
		$this->checkAdmin();

		$model = Gifts::getAllExpandedArray();

		return $this->render('list', [
			'model' => $model,
		]);
    }


    /**
     * Poof Gift.
     *
     * @return mixed
     */
    public function actionProof($id)
    {
		$this->checkAdmin();

		$gift = Gifts::findById($id);

		if($gift->changeStatus(10)) {
			$user_id = \Yii::$app->user->identity->id;
			$mail = new UserMails;
			$user = User::findUserById($user_id);
			$mail->giftProofEmail($user);
		}

		return $this->actionList();
    }

    /**
     * Reject Gift.
     *
     * @return mixed
     */
    public function actionReject($id)
    {
		$this->checkAdmin();

		$gift = Gifts::findById($id);

		if($gift->changeStatus(0)) {
			$user_id = \Yii::$app->user->identity->id;
			$mail = new UserMails;
			$user = User::findUserById($user_id);
			$mail->giftRejectEmail($user);
		}

		return $this->actionList();
    }

    /**
     * Reject Gift.
     *
     * @return mixed
     */
    public function actionGivenout($id)
    {
		$this->checkAdmin();

		$gift = Gifts::findById($id);
		$gift->changeStatus(20);

		return $this->actionList();
    }
}