<?php

use common\models\Roles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-education', 'aria-hidden' => 'true']) . ' Все в школу', ['study'], ['data-method' => 'post', 'aria-label' => 'Изменить роли продавцов', 'data-confirm' => 'Вы уверены, что хотите изменить роли всех продавцов?', 'class' => 'btn btn-success']) ?>
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
        'columns'	=>	[
			[
				'attribute'		=>	'id',
				'format'		=>	'text',
				'headerOptions'	=>	['width' => '50'],
			],
			[
				'attribute'	=>	'subdivision',
				'format'	=>	'raw',
				'value'		=>	function($data){
					$subdivision = $data->getSubdivision($data->profile->subdivision);
					return $subdivision->name;
				},
				'filter'	=>	$subdivisionList,
			],
			[
				'attribute'	=>	'username',
				'format'	=>	'raw',
				'headerOptions'	=>	['width' => '90'],
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
				'attribute'	=>	'role',
				'format'	=>	'raw',
				'headerOptions'	=>	['width' => '80'],
				'contentOptions' => ['class' => 'text-center'],
				'value'		=>	function($data){
					$role = $data->getRole($data->role);
					return '<span class="text-'.$role->color.'" data-toggle="tooltip" data-placement="top" title="'.$role->name.'"><span class="glyphicon glyphicon-'.$role->ico.'" aria-hidden="true"></span></span>';
				},
				'filter'	=>	$rolesList,
			],
			[
				'attribute'	=>	'created_at',
				'format'	=>	['date', 'dd.MM.Y'],
				'headerOptions'	=>	['width' => '100'],
			],
			[
				'class'			=>	'yii\grid\ActionColumn',
				'header'		=>	'Управление',
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

</div>
