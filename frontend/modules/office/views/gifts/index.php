<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GiftsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="gifts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
				'attribute'=>'model',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						//$data->prizes->name,
						$data->model==0?'Не выбран':$data->prizes->name,
						Url::to(['/office/gifts/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть информацию о подарке',
						]
					);
				}
			],
			[
				'attribute'=>'user_id',
				'format' => 'raw',
				'value' => function($data){

					return Html::a(
						$data->user->username,
						Url::to(['/office/user/view/', 'id' => $data->user->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть информацию о пользователе',
						]
					);
				}
			],
			[
				'attribute' => 'rating',
				'format' => 'raw',
				'headerOptions' => ['width' => '90'],
			],
			[
				'attribute' => 'created_at',
				'format' =>  ['date', 'dd.MM.Y'],
				'headerOptions' => ['width' => '90'],
			],
			[
				'attribute' => 'price',
				'format' => 'raw',
				'headerOptions' => ['width' => '90'],
			],
			[
				'attribute' => 'condition',
				'format' => 'raw',
				'filter' => [ 0 => 'Отклонен', 1 => 'В ожидании', 5 => 'Приз выбран', 10 => 'Подтвержден', 20 => 'Выдан' ],
				'headerOptions' => ['width' => '60'],
				'value' => function($data){
					if( $data->condition == 0 ) {
						return '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
					} elseif( $data->condition == 5 ) {
						return '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Приз выбран"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span></span>';
					} elseif( $data->condition == 10 ) {
						return '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтвержден"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
					} elseif( $data->condition == 20 ) {
						return '<span href="#" class="text-rimary" data-toggle="tooltip" data-placement="top" title="Выдан"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></span>';
					} else {
						return '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Продавец не выбрал подарок."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
					}
				}
			],

			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Управление',
				'headerOptions' => ['width' => '115'],
				'template' => '{view} {delete} {reject} {proof} {resurect} {issued} ',
				'buttons' => [
					'view' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Подробнее']);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
						$url, ['data-method' => 'post', 'aria-label' => 'Удалить', 'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить']);
					},
					'reject' => function ($url,$model,$key) {
						if( $model->condition==1 || $model->condition==5 ) {
							return Html::a(
								'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Отклонить подарок']
							);
						} else {
							return '';
						}
					},
					'proof' => function ($url,$model,$key) {
						if( $model->condition==5 ) {
							return Html::a(
								'<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Одобрить подарок']
							);
						} else {
							return '';
						}
					},
					'resurect' => function ($url,$model,$key) {
						if( $model->condition==0 || $model->condition==10 ) {
							return Html::a(
								'<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Отменить действия администратора']
							);
						} else {
							return '';
						}
					},
					'issued' => function ($url,$model,$key) {
						if( $model->condition==10 ) {
							return Html::a(
								'<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Отметить как выданный']
							);
						} else {
							return '';
						}
					},
				],
			],
        ],
    ]); ?>

</div>
