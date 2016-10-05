<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Roles;
use common\models\Post;
use common\models\FaqSearch;
use common\models\Taxonomy;
use common\models\PostForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FaqController implements the CRUD actions for Post model.
 */
class FaqController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'draft', 'visible', 'archive', 'single'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'draft', 'visible'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'actions' => ['archive', 'single'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'rolesList' => Taxonomy::getChildrensBySlugArray('faq'),
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$prohibition = Taxonomy::getProhibitionById($model->category);
        return $this->render('view', [
            'model' => $model,
			'role' => $model->getRole($prohibition),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostForm();
		$tax = Taxonomy::findBySlug('faq');
		$model->category = $tax->id;

        if ($model->load(Yii::$app->request->post())) {
			$model->register(true);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'tax' => Taxonomy::getChildrensBySlugArray('faq'),
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new PostForm();
		$tax = Taxonomy::findBySlug('faq');
		$model->category = $tax->id;

        if ($model->load(Yii::$app->request->post())) {
			$model->id = $id;
			$model->register(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
			$model->loadData($id);
            return $this->render('update', [
                'model' => $model,
				'tax' => Taxonomy::getChildrensBySlugArray('faq'),
            ]);
        }
    }


    /**
     * Displays Archive page.
     *
     * @return mixed
     */
    public function actionArchive()
    {

		$tax = Taxonomy::findByProhibition(\Yii::$app->user->identity->role, 'faq');

		if( $tax ) {

			$searchModel = new FaqSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tax->id);

			if( $dataProvider->totalCount > 0 ) {
				return $this->render('archive', [
					'dataProvider' => $dataProvider,
				]);
			}
		}
		return $this->render('_nofaq');
    }


    /**
     * Displays Piece of News.
     *
     * @return mixed
     */
    public function actionSingle($id)
    {
		return $this->render('single', [
			'model' => Post::findCompleteById($id),
		]);
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->session->setFlash('success', 'Раздел справки удален.');
        return $this->redirect(['index']);
    }


    /**
     * News draft.
     *
     * @return mixed
     */
    public function actionDraft($id)
    {
		$post = Post::findById($id);
		$post->changeStatus();

		return $this->actionIndex();
    }


    /**
     * News visible.
     *
     * @return mixed
     */
    public function actionVisible($id)
    {
		$post = Post::findById($id);
		$post->changeStatus(false);

		return $this->actionIndex();
    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошенная Вами страница не найдена.');
        }
    }
}
