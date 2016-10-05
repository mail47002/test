<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
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
				'attribute'=>'img',
				'format' => 'raw',
				'headerOptions' => ['width' => '60'],
				'value' => function($data){
					if($data->img=='') {
						$color = 'danger';
						$hint = 'Нет изображения';
					} else {
						$color = 'success';
						$hint = 'Изображение загружено';
					}
					return '<span class="text-'.$color.'" data-toggle="tooltip" data-placement="top" title="'.$hint.'">
						<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
					</span>';
				}
			],
			[
				'attribute'=>'name',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->name,
						Url::to(['/office/products/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть товар',
						]
					);
				}
			],
			[
				'attribute'=>'cat',
				'format' => 'raw',
				'value' => function($data){
					return $data->taxonomy->name;
				}
			],
			[
				'attribute'=>'manufacturer',
				'format' => 'raw',
				'value' => function($data){
					return $data->manufacturers->name;
				}
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Управление',
				'headerOptions' => ['width' => '115'],
				'template' => '{draft} {visible} {view} {update} {delete}',
				'buttons' => [
					'draft' => function ($url,$model,$key) {
						if($model->draft==0) {
							return Html::a(
								'<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link text-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Опубликовано - изменить']
							);
						} else {
							return '';
						}
					},
					'visible' => function ($url,$model,$key) {
						if($model->draft==1) {
							return Html::a(
								'<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link text-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Черновик - изменить']
							);
						} else {
							return '';
						}
					},
					'view' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Подробнее']);
					},
					'update' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Изменить товар' ]);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
						$url, ['data-method' => 'post', 'aria-label' => 'Удалить', 'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить товар']);
					},
				],
			],
        ],
    ]); ?>

</div>
