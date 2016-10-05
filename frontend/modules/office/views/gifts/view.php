<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Gifts */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = $prizes?'Подарок: ' . $prizes->name:'Подарок #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



// Condition
$condition[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает выбора подарка."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$condition[5] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подарок выбран"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span></span>';
$condition[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтвержден"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$condition[20] = '<span href="#" class="text-primary" data-toggle="tooltip" data-placement="top" title="Подарок выдан"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></span>';

$condition[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';

// Profile link
if($admin_mode) {
	$profile_link = ['user/view', 'id' => $model->user_id];
} else {
	$profile_link = ['user/viewinfo'];
}

?>
	<article class="gifts-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<div class="row">

			<?php
				if( $admin_mode ) {
			?>
			<div class="col-sm-12 text-right">
				<span class="small text-info">Управление подарком</span>
			</div>
			<div class="col-sm-12">
				<div class="well well-md">

					<?= Html::a('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><span class="hidden-xs"> К списку</span>', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

					<?php if( $model->condition == 0 || $model->condition == 10 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><span class="hidden-xs"> Восстановить</span>', ['resurect', 'id' => $model->id], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Отменить действия администратора']) ?>
					<?php } ?>

					<?php if( $model->condition == 10) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span><span class="hidden-xs"> Выдан</span>', ['issued', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
					<?php } ?>

					<?php if( $model->condition == 5 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span><span class="hidden-xs"> Одобрить</span>', ['proof', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
					<?php } ?>

					<?php if( $model->condition == 1 || $model->condition == 5 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><span class="hidden-xs"> Отклонить</span>', ['reject', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
					<?php } ?>

					<?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs"> Удалить</span>', ['delete', 'id' => $model->id], [
						'class' => 'btn btn-danger',
						'data' => [
							'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
							'method' => 'post',
						],
					]) ?>

				</div>
			</div>
			<?php
				}
			?>

			<?php
				if( !$admin_mode && $model->condition == 1 ) {
			?>
			<div class="col-sm-12 text-right">
				<span class="small text-info">Управление продажей</span>
			</div>
			<div class="col-sm-12">
				<div class="well well-md">
					<?= Html::a('<span class="glyphicon glyphicon-gift" aria-hidden="true"></span><span class="hidden-xs"> Выбрать подарок</span>', ['select', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
				</div>
			</div>
			<?php
				}
			?>

			<div class="col-sm-12">

				<?= DetailView::widget([
					'model' => $model,
					'options' => [
						'class' => 'table table-striped element-view',
					],
					'attributes' => [
					'id',
						[
							'attribute'	=>	'user_id',
							'format'	=>	'raw',
							'value'		=>	Html::a($username, Url::to($profile_link)),
						],
						[
							'attribute'	=>	'model',
							'format'	=>	'raw',
							'value'		=>	$model->model==0?'Не выбран':Html::a($prizes->name, Url::to(['prizes/single', 'id' => $prizes->id])),
						],
						[
							'attribute' => 'created_at',
							'format' =>  ['date', 'dd.MM.Y'],
						],
						[
							'attribute'	=>	'condition',
							'format'	=>	'raw',
							'value'		=>	$condition[$model->condition],
						],
					'price',
					'place',
					'rating',
					],
				]) ?>

			</div>

		</div><!-- /.row -->
	</article><!-- /.gifts-view -->
