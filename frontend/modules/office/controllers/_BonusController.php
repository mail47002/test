<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Products;
use common\models\User;
use common\models\Taxonomy;
use common\models\Manufacturers;
use common\models\ProductForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;


/**
 * Bonus controller
 */
class BonusController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'gifts', 'products', 'add', 'edit'],
                'rules' => [
                    [
                        'actions' => ['index', 'gifts', 'products', 'add', 'edit'],
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
     * Render Products.
     *
     * @return mixed
     */
	private function renderProductsList()
	{
		return $this->render('products', [
			'model' => Products::getAll(),
			'categoriesList' => Taxonomy::getChildrensBySlugArray('products'),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
	}


    /**
     * Displays Products list.
     *
     * @return mixed
     */
    public function actionProducts()
    {
		$this->checkAdmin();
		return $this->renderProductsList();
    }


    /**
     * Displays Bonuses list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->render('index', [
			'model' => Products::getAllBonuses(),
			'categoriesList' => Taxonomy::getChildrensBySlugArray('products'),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
    }


    /**
     * Displays Gifts list.
     *
     * @return mixed
     */
    public function actionGifts()
    {
		return $this->render('gifts', [
			'model' => Products::getAllGifts(),
			'categoriesList' => Taxonomy::getChildrensBySlugArray('products'),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
    }


    /**
     * Displays Bonuses list.
     *
     * @return mixed
     */
    public function actionProductCardBonus($id)
    {
		$model = Products::findCompleteById($id);
		return $this->render('productCard', [
			'model' => $model,
			'flag' => 'bonus',
		]);
    }


    /**
     * Displays Bonuses list.
     *
     * @return mixed
     */
    public function actionProductCardGift($id)
    {
		$model = Products::findCompleteById($id);
		return $this->render('productCard', [
			'model' => $model,
			'flag' => 'gift',
		]);
    }


    /**
     * Create Product.
     *
     * @return mixed
     */
    public function actionAdd()
    {
		$this->checkAdmin();

        $model = new ProductForm();

        if ($model->load(Yii::$app->request->post())) {
			$model->register(true);
			return $this->renderProductsList();
		}

		return $this->render('edit', [
			'edit' => false,
			'model' => $model,
			'categoriesList' => Taxonomy::getChildrensBySlugArray('products'),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
    }


    /**
     * Edit Product.
     *
     * @return mixed
     */
    public function actionEdit($id)
    {
		$this->checkAdmin();

        $model = new ProductForm();

        if ($model->load(Yii::$app->request->post())) {
			$model->id = $id;
			$model->register(false);
			return $this->renderProductsList();
		}

		$model->loadData($id);
		return $this->render('edit', [
			'edit' => true,
			'model' => $model,
			'categoriesList' => Taxonomy::getChildrensBySlugArray('products'),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
    }



    /**
     * Turn Off Bonus.
     *
     * @return mixed
     */
    public function actionBonusoff($id)
    {
		$this->checkAdmin();

		$product = Products::findById($id);
		$product->changeBonusStatus(false);

		return $this->renderProductsList();
    }

    /**
     * Turn On Bonus.
     *
     * @return mixed
     */
    public function actionBonuson($id)
    {
		$this->checkAdmin();

		$product = Products::findById($id);
		$product->changeBonusStatus();

		return $this->renderProductsList();
    }

    /**
     * Turn Off Gift.
     *
     * @return mixed
     */
    public function actionGiftoff($id)
    {
		$this->checkAdmin();

		$product = Products::findById($id);
		$product->changeGiftStatus(false);

		return $this->renderProductsList();
    }

    /**
     * Turn On Gift.
     *
     * @return mixed
     */
    public function actionGifton($id)
    {
		$this->checkAdmin();

		$product = Products::findById($id);
		$product->changeGiftStatus();

		return $this->renderProductsList();
    }

}