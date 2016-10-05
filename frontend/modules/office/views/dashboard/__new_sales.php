<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

				<div class="new-sales-list">

    <?= GridView::widget([
		'options' => [
            'class' => 'grid-view table-responsive'
        ],
		'showOnEmpty' => false,
		'emptyText' => '',
		'summary' => '<h2 class="text-success">Новые регистрации продаж</h2>',
		'tableOptions' => [
            'class' => 'table'
        ],
		'rowOptions' => function ($model, $key, $index, $grid) {
			return ['class' => 'success'];
		},
        'dataProvider' => $salesDataProvider,
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
						$hint = 'Продавец не загрузил изображение';
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
				'attribute'=>'model',
				'format' => 'raw',
				'value' => function($data){

					return Html::a(
						$data->products->name,
						Url::to(['/office/sales/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть информацию о продаже',
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
				'attribute' => 'date',
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
				'controller'	=>	'sales',
				'headerOptions' => ['width' => '115'],
				'template' => '{view} {delete} {reject} {proof}',
				'buttons' => [
					'view' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Подробнее']);
					},
					'reject' => function ($url,$model,$key) {
						if($model->condition!=0 && $model->condition!=20) {
							return Html::a(
								'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Отклонить продажу']
							);
						} else {
							return '';
						}
					},
					'proof' => function ($url,$model,$key) {
						if($model->condition!=10 && $model->condition!=20) {
							return Html::a(
								'<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>',
								$url,
								['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Одобрить продажу']
							);
						} else {
							return '';
						}
					},
					'delete' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
						$url, ['data-method' => 'post', 'aria-label' => 'Удалить', 'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить']);
					},
				],
			],
        ],
    ]); ?>

				</div><!--/.new-sales-list -->