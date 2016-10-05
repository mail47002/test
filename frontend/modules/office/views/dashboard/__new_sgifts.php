<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>
				<div class="new-gifts-list">

    <?= GridView::widget([
		'options' => [
            'class' => 'grid-view table-responsive'
        ],
		'showOnEmpty' => false,
		'emptyText' => '',
		'summary' => '<h2 class="text-danger">Не выданы подарки продавцам</h2>',
		'tableOptions' => [
            'class' => 'table table-striped'
        ],
		'rowOptions' => function ($model, $key, $index, $grid) {
			return ['class' => 'danger'];
		},
        'dataProvider' => $giftsDataProvider,
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
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Управление',
				'controller'	=>	'gifts',
				'headerOptions' => ['width' => '125'],
				'template' => '{view} {delete} {reject} {proof} {issued} ',
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
						if( $model->condition!=0 && $model->condition!=10 && $model->condition!=20 ) {
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
						if( $model->condition!=1 && $model->condition!=10 && $model->condition!=20 ) {
							return Html::a(
								'<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Одобрить подарок']
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

				</div><!--/.new-gifts-list -->
