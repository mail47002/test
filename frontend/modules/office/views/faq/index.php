<?php

use common\models\Roles;
use common\models\Taxonomy;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Справка';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать раздел справки', ['create'], ['class' => 'btn btn-success']) ?>
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
				'attribute'=>'title',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->title,
						Url::to(['/office/faq/view/', 'id' => $data->id]),
						[
							'data-toggle' => 'tooltip',
							'data-placement' => 'top',
							'title' => 'Просмотреть новость',
						]
					);
				}
			],
            'slug',
			[
				'attribute'	=>	'category',
				'format'	=>	'raw',
				//'headerOptions'	=>	['width' => '100'],
				'contentOptions' => ['class' => 'text-center'],
				'value'		=>	function($data){
					$prohibition = Taxonomy::getProhibitionById($data->category);
					$role = $data->getRole($prohibition);
					return '<span class="text-'.$role->color.'" data-toggle="tooltip" data-placement="top" title="'.$role->name.'"><span class="glyphicon glyphicon-'.$role->ico.'" aria-hidden="true"></span></span>';
				},
				'filter' => $rolesList,
			],
			[
				'attribute' => 'created_at',
				'format' =>  ['date', 'dd.MM.Y'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Управление',
				'headerOptions' => ['width' => '120'],
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
						$url, ['class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Изменить справку' ]);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a(
						'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
						$url, ['data-method' => 'post', 'aria-label' => 'Удалить справку', 'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'class' => 'action-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Удалить']);
					},
				],
			],
        ],
    ]); ?>

</div>
