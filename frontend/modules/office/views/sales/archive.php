<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Продажи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sales-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <span class="control-btn">
        <?= Html::a(Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Зарегистрировать продажу', ['create'], ['class' => 'btn btn-success']) ?>
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
				'headerOptions' => ['width' => '50'],
			],
			[
				'attribute'=>'img',
				'format' => 'raw',
				'headerOptions' => ['width' => '50'],
				'value' => function($data){
					if($data->img=='') {
						$color = 'danger';
						$hint = 'Изображение не загружено';
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
				'attribute' => 'date',
				'format' =>  ['date', 'dd.MM.Y'],
				'headerOptions' => ['width' => '100'],
			],
			[
				'attribute' => 'price',
				'format' => 'raw',
				'headerOptions' => ['width' => '100'],
			],
			[
				'attribute' => 'condition',
				'format' => 'raw',
				'filter' => [ 0 => 'Отклонена', 1 => 'В ожидании' , 10 => 'Одобрена', 20 => 'Архивная' ],
				'headerOptions' => ['width' => '60'],
				'value' => function($data){
					if( $data->condition == 0 ) {
						return '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
					} elseif( $data->condition == 10 ) {
						return '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтверждено"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
					} elseif( $data->condition == 20 ) {
						return '<span href="#" class="text-primary" data-toggle="tooltip" data-placement="top" title="Продажа в архиве"><span class="glyphicon glyphicon-compressed" aria-hidden="true"></span></span>';
					} else {
						return '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора. Не участвует в общем подсчете."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
					}
				}
			],
        ],
    ]); ?>

</div>
