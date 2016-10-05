<?php

namespace frontend\modules\office\controllers;

use Yii;
use common\models\Prizes;
use common\models\PrizesSearch;
use common\models\PrizesForm;
use common\models\Taxonomy;
use common\models\RatingSections;
use common\models\Manufacturers;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;

/**
 * PrizesController implements the CRUD actions for Prizes model.
 */
class TestController extends Controller
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
                        'roles' => ['sdo'],
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
     * Lists all Prizes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrizesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionArchive()
    {

        return $this->render('archive', [
            'model' => Prizes::getAllPrizes(),
			'categoriesList' => RatingSections::getAllArray(),
        ]);
    }

    /**
     * Displays a single Prizes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);

        return $this->render('view', [
			'model' => $model,
			'category' => RatingSections::findById($model->cat),
			'manufacturer' => Manufacturers::findById($model->manufacturer),
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionSingle($id)
    {
        return $this->render('single', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Prizes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrizesForm();

        if ($model->load(Yii::$app->request->post())) {
			$model->register(true);
            return $this->redirect(['view', 'id' => $model->id]);
        }

		return $this->render('create', [
			'model' => $model,
			'categoriesList' => RatingSections::getAllArray(),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);

    }

    /**
     * Updates an existing Prizes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new PrizesForm();

        if ($model->load(Yii::$app->request->post())) {
			$model->id = $id;
			$model->register(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

		$model->loadData($id);
		return $this->render('update', [
			'model' => $model,
			'categoriesList' => RatingSections::getAllArray(),
			'manufacturersList' => Manufacturers::getAllArray(),
		]);
    }

    /**
     * Deletes an existing Prizes model.
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
     * Prizes draft.
     *
     * @return mixed
     */
    public function actionDraft($id)
    {
		$post = $this->findModel($id);
		$post->changeStatus();

		return $this->actionIndex();
    }


    /**
     * Prizes visible.
     *
     * @return mixed
     */
    public function actionVisible($id)
    {
		$post = $this->findModel($id);
		$post->changeStatus(false);

		return $this->actionIndex();
    }


    /**
     * Finds the Prizes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prizes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prizes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошенная Вами страница не найдена.');
        }
    }
}
