<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfileDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Параметры профиля';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="profile-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать параметр профиля', ['create'], ['class' => 'btn btn-success']) ?>
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
				'attribute'=>'name',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->name,
						Url::to(['/office/profile-details/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть параметр профиля',
						]
					);
				}
			],

			[
				'attribute'=>'implement',
				'format'=>'text', // Возможные варианты: raw, html
				'content'=>function($data){
					return $data->getImplementName();
				},
				'filter' => $parentList,
			],

			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Управление',
				'headerOptions' => ['width' => '110'],
				'template' => '{view} {update} {delete}',
				'buttons' => [
					'view' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Подробнее']);
					},
					'update' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Изменить параметр профиля']);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
						$url, ['data-method' => 'post', 'aria-label' => 'Удалить', 'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить параметр профиля']);
					},
				],
			],
        ],
    ]); ?>
</div>

