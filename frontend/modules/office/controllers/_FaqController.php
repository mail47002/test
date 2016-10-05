<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Post;
use common\models\User;
use common\models\Taxonomy;
use common\models\PostForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;


/**
 * Bonus controller
 */
class FaqController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['archive', 'wiew', 'products', 'add', 'edit', 'index'],
                'rules' => [
                    [
                        'actions' => ['archive', 'wiew', 'products', 'add', 'edit', 'index'],
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
	private function checkRole($id)
	{
		if( \Yii::$app->user->identity->role != 77 ) {
			if (\Yii::$app->user->identity->role != Taxonomy::getProhibitionById($id)) {
				return $this->redirect('index.php?r=office%2Fdashboard%2Findex');
			}
		}
	}

    /**
     * Render edit FAQ.
     *
     * @return mixed
     */
	private function renderEditFaq($id = false)
	{
        $model = new PostForm();
		$tax = Taxonomy::findBySlug('faq');

        if ($model->load(Yii::$app->request->post())) {
			if( $id ) {
				$model->id = $id;
				$model->register(false);
			} else {
				$model->register(true);
			}
			return $this->actionList();
		}

		if( $id ) {
			$model->loadData($id);
			$edit = true;
		} else {
			$edit = false;
		}

		return $this->render('edit', [
			'edit' => $edit,
			'model' => $model,
			'tax' => Taxonomy::getChildrensBySlugArray('faq'),
		]);
	}


    /**
     * Displays Archive page.
     *
     * @return mixed
     */
    public function actionArchive()
    {
		$tax = Taxonomy::findByProhibition(\Yii::$app->user->identity->role);

		if( !$tax ) {
			return $this->render('index');
		} else {
			return $this->render('archive', [
				'model' => Post::getArchiveById($tax->id, 20),
			]);
		}
    }


    /**
     * Displays Archive page.
     *
     * @return mixed
     */
    public function actionList()
    {
		$this->checkAdmin();

		return $this->render('list', [
			'model' => Post::getSubArchive('faq', 50, true),
			'tax' => Taxonomy::getChildrensBySlugArray('faq', true),
		]);
    }


    /**
     * Displays Piece of News.
     *
     * @return mixed
     */
    public function actionView($id)
    {
		$tax_id = Post::getTaxId($id);
		$this->checkRole($tax_id); 

		return $this->render('view', [
			'model' => Post::findCompleteById($id),
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

		return $this->renderEditFaq();
    }


    /**
     * Edit Product.
     *
     * @return mixed
     */
    public function actionEdit($id)
    {
		$this->checkAdmin();

		return $this->renderEditFaq($id);
    }


    /**
     * Edit Product.
     *
     * @return mixed
     */
    public function actionDraft($id)
    {
		$this->checkAdmin();

		$post = Post::findById($id);
		$post->changeStatus();

		return $this->actionList();
    }


    /**
     * Edit Product.
     *
     * @return mixed
     */
    public function actionVisible($id)
    {
		$this->checkAdmin();

		$post = Post::findById($id);
		$post->changeStatus(false);

		return $this->actionList();
    }

}