<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileDetails */

$this->title = 'Параметр профиля: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Параметр профиля', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<article class="page-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<div class="row">

			<div class="col-sm-12 text-right">
				<span class="small text-info">Управление</span>
			</div>

			<div class="col-sm-12">
				<div class="well well-md">
					<?= Html::a('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><span class="hidden-xs"> К списку</span>', ['index'], ['class' => 'btn btn-primary']) ?>
					<?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><span class="hidden-xs"> Изменить</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
					'name',
					[
						'attribute'=>'implement',
						'value'=>$parentName,
					],
				],
			]) ?>

			</div>

		</div><!-- /.row -->
	</article><!-- /.page-view -->
