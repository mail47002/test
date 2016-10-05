<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sales */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Продажа: ' . $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Condition
$condition[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора. Не участвует в общем подсчете."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$condition[10] = '<span class="text-success" data-toggle="tooltip" data-placement="top" title="Подтверждено"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$condition[20] = '<span class="text-primary" data-toggle="tooltip" data-placement="top" title="Архивная"><span class="glyphicon glyphicon-compressed aria-hidden="true"></span></span>';
$condition[0] = '<span class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';

// Img
$profile_dir = '@web/uploads/sales/';
if( $model->img != '' ) {
	$profile_img = $profile_dir . $model->img;
	$img = '			<div class="sales-img center-block img-responsive">';
	$img .= '				' . Html::img($profile_img, ['alt'=>$product->name, 'class'=>'img-responsive']);
	$img .= '			</div>';
} else {
	$img = 'Изображение не загружено.';
}

// Profile link
if($admin_mode) {
	$profile_link = ['user/view', 'id' => $model->user_id];
} else {
	$profile_link = ['user/viewinfo'];
}

?>
	<article class="sales-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<div class="row">
			<?php
				if( $admin_mode ) {
			?>
			<div class="col-sm-12 text-right">
				<span class="small text-info">Управление продажей</span>
			</div>
			<div class="col-sm-12">
				<div class="well well-md">

					<?= Html::a('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><span class="hidden-xs"> К списку</span>', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

					<?php if( $model->condition != 10 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span><span class="hidden-xs"> Одобрить</span>', ['proof', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
					<?php } ?>

					<?php if( $model->condition != 0 ) { ?>
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
							'value'		=>	Html::a($product->name, Url::to(['products/single', 'id' => $product->id])),
						],
						'emei1',
						'emei2',
						'serial',
						[
							'attribute' => 'date',
							'format' =>  ['date', 'dd.MM.Y'],
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
						[
							'attribute'	=>	'img',
							'format'	=>	'raw',
							'value'		=>	$img,
						],
					],
				]) ?>

			</div>

		</div><!-- /.row -->
	</article><!-- /.sales-view -->
