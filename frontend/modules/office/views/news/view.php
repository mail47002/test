<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
$this->registerJsFile('@web/js/tooltip.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Новость: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Draft
$draft = '<span class="text-'.($model->draft==1?'danger':'success').'" data-toggle="tooltip" data-placement="top" title="'.($model->draft==1?'Закрыто':'Просмотр разрешен').'">';
$draft .= '<span class="glyphicon glyphicon-eye-'.($model->draft==1?'close':'open').'" aria-hidden="true"></span>';
$draft .= '</span>';

// Img
$profile_dir = '@web/uploads/post/';
if( $model->img != '' ) {
	$profile_img = $profile_dir . $model->img;
	$img = '			<div class="news-img center-block">';
	$img .= '				' . Html::img($profile_img, ['alt'=>$model->title, 'class'=>'img-responsive']);
	$img .= '			</div>';
} else {
	$img = 'Изображение не загружено.';
}

?>
	<article class="post-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<div class="row">

			<div class="col-sm-12">
				<div class="well well-md">
					<?= Html::a('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><span class="hidden-xs"> К списку</span>', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
					<?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><span class="hidden-xs"> Изменить</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
					<?= Html::a('<span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="hidden-xs"> Карточка</span>', ['single', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

					<?php if( $model->draft==0 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><span class="hidden-xs"> Открыто</span>', ['draft', 'id' => $model->id], ['class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Закрыть от просмотра']) ?>
					<?php } ?>

					<?php if( $model->draft==1 ) { ?>
						<?= Html::a('<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span><span class="hidden-xs"> Черновик</span>', ['visible', 'id' => $model->id], ['class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Открыть для просмотра']) ?>
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

			<div class="col-sm-12">

				<?= DetailView::widget([
					'model' => $model,
					'options' => [
						'class' => 'table table-striped element-view',
					],
					'attributes' => [
						'id',
						[
							'attribute'	=>	'draft',
							'format'	=>	'raw',
							'value'		=>	$draft,
						],

						'slug',
						'title',
						//'category',
						[
							'attribute' => 'created_at',
							'format' =>  ['date', 'dd.MM.Y'],
						],
						'excerpt',
						'content:ntext',
						[
							'attribute'	=>	'img',
							'format'	=>	'raw',
							'value'		=>	$img,
						],
					],
				]) ?>

			</div>

		</div><!-- /.row -->
	</article><!-- /.post-view -->
