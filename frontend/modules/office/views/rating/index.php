<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Управление рейтингом';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="rating-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-flag', 'aria-hidden' => 'true']) . ' Начать новый рейтинг ', ['create'], [
			'class' => 'btn btn-success',
			'data' => [
					'confirm' => 'Вы уверены, что хотите начать новый рейтинг?',
					'method' => 'post',
				],
		]) ?>
    </span>

    <?= GridView::widget([
		'options' => [
            'class' => 'grid-view table-responsive'
        ],
		'showOnEmpty' => false,
		'emptyText' => '<div class="summary">В данном разделе нет никаких записей.</div>',
		'summary' => '<div class="summary">Показано <b>{begin}</b> - <b>{end}</b> из <b>{totalCount}</b>.</div>',
		'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			[
				'attribute'=>'id',
				'format'=>'text',
				'headerOptions' => ['width' => '60'],
			],
			[
				'attribute' => 'status',
				'format' => 'raw',
				'filter' => [ 1 => 'Текущий', 10 => 'Законцчен' ],
				'headerOptions' => ['width' => '60'],
				'value' => function($data){
					if( $data->status == 1 ) {
						return '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Текущий круг рейтинга"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span></span>';
					} else {
						return '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Данный круг завершен"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span></span>';
					}
				}
			],
			[
				'attribute' => 'date_from',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						Yii::$app->formatter->asDatetime($data->date_from, Yii::$app->params['dateFormat']),
						Url::to(['/office/rating/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть информацию о рейтинге',
						]
					);
				}
			],
			[
				'attribute' => 'date_to',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->status==1?'Продолжается':Yii::$app->formatter->asDatetime($data->date_to, Yii::$app->params['dateFormat']),
						Url::to(['/office/rating/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть информацию о рейтинге',
						]
					);
				}
			],
        ],
    ]); ?>

</div>
