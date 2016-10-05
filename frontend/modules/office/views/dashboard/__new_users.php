<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>
				<div class="new-users-list">

    <?= GridView::widget([
		'options' => [
            'class' => 'grid-view table-responsive'
        ],
//		'showHeader' => false,
		'showOnEmpty' => false,
		'emptyText' => '',
		'summary' => '<h2 class="text-warning">Новые пользователи</h2>',
		'tableOptions' => [
            'class' => 'table'
        ],
		'rowOptions' => function ($model, $key, $index, $grid) {
			return ['class' => 'warning'];
		},
        'dataProvider' => $usersDataProvider,
        'columns'	=>	[
			[
				'attribute'		=>	'id',
				'format'		=>	'text',
				'headerOptions'	=>	['width' => '50'],
			],
			[
				'attribute'	=>	'username',
				'format'	=>	'raw',
				'value'		=>	function($data){
					return Html::a(
						$data->username,
						Url::to(['/office/user/view/', 'id' => $data->id]),
						[
							'data-toggle'		=>	'tooltip',
							'data-placement'	=>	'top',
							'title'				=>	'Просмотреть профиль пользователя ' . $data->username,
						]
					);
				},
			],
            'email:email',
			[
				'attribute'	=>	'created_at',
				'format'	=>	['date', 'dd.MM.Y'],
			],
			[
				'class'			=>	'yii\grid\ActionColumn',
				'header'		=>	'Управление',
				'controller'	=>	'user',
				'headerOptions'	=>	['width' => '175'],
				'template'		=>	'{turnoff} {turnon} {view} {profile} {update} {delete} {proof}',
				'buttons'		=>	[
						'turnoff' => function ($url,$model,$key) {
							if($model->status==10) {
								return Html::a(
									'<span class="glyphicon glyphicon-off" aria-hidden="true"></span>',
									$url,
									['class' => 'action-link text-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Заблокировать пользователя']
								);
							} else {
								return '';
							}
						},
						'turnon' => function ($url,$model,$key) {
							if($model->status==0) {
								return Html::a(
									'<span class="glyphicon glyphicon-off" aria-hidden="true"></span>',
									$url,
									['class' => 'action-link text-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Разблокировать пользователя']
								);
							} else {
								return '';
							}
						},
						'view'		=>	function($url,$model,$key) {
							return Html::a(
							'<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
							$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Просмотреть профиль пользователя ' . $model->username]);
						},
						'profile'		=>	function($url,$model,$key) {
							return Html::a(
							'<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
							$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Изменить профиль пользователя ' . $model->username]);
						},
						'update' => function ($url,$model,$key) {
							return Html::a(
							'<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
							$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Изменить роль пользователя']);
						},
						'delete' => function ($url,$model,$key) {
							return Html::a(
							'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
							$url, ['data-method' => 'post', 'aria-label' => 'Удалить', 'data-confirm' => 'Вы уверены, что хотите удалить пользователя?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить пользователя']);
						},
						'proof' => function ($url,$model,$key) {
							if($model->role==4) {
								return Html::a(
									'<span class="text-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>',
									$url,
									['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Одобрить пользователя']
								);
							} else {
								return '';
							}
						},
				],
			],
        ],
    ]);

?>
				</div><!--/.new-users-list -->