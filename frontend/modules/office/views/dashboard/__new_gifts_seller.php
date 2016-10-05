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
		'showHeader' => false,
		'showOnEmpty' => false,
		'emptyText' => '',
		'summary' => '<h2 class="text-success">Вы получили подарок</h2>',
		'tableOptions' => [
            'class' => 'table table-striped'
        ],
		'rowOptions' => function ($model, $key, $index, $grid) {
			return ['class' => 'success'];
		},
        'dataProvider' => $giftsDataProvider,
        'columns' => [
			[
				'attribute'=>'id',
				'format'=>'text',
				'headerOptions' => ['width' => '60'],
				'value' => function($data){
					return '# ' . $data->id;
				}
			],
			[
				'attribute'=>'model',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						//$data->prizes->name,
						'<span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Выбрать подарок',
						Url::to(['/office/gifts/select/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Выбрать подарок',
						]
					);
				}
			],
			[
				'attribute' => 'created_at',
				'format' => 'raw',
				'headerOptions' => ['width' => '90'],
				'value' => function($data){
					return '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> ' . Yii::$app->formatter->asDatetime($data->created_at, Yii::$app->params['dateFormat']);
				}
			],
			[
				'attribute' => 'price',
				'format' => 'raw',
				'headerOptions' => ['width' => '90'],
				'value' => function($data){
					return '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> ' . $data->price . ' баллов';
				}
			],
        ],
    ]); ?>

				</div><!--/.new-gifts-list -->
