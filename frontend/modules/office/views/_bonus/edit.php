<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->registerJsFile('@web/js/profile-edit.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = $edit?'Изменить товар ' . $model->name:'Добавить новый товар';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-bonus-edit" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

				<?php $form = ActiveForm::begin(['id' => 'form-bonus-edit','options' => ['enctype'=>'multipart/form-data', 'class' => 'bonus-edit', 'name' => 'bonus-edit']]); ?>

				<div class="row">
				
					<div class="col-sm-8">

							<?= $form->field($model, 'name') ?>

							<?= $form->field($model, 'excerpt')->textArea(['rows' => '3']) ?>

							<?= $form->field($model, 'description')->textArea(['rows' => '8']) ?>

							<?= $form->field($model, 'url') ?>

							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<span class="lead text-success">Миниатюра товара</span>
									</div>
									<?= $form->field($model, 'img')->fileInput() ?>
								</div>
								<div class="col-xs-6 product-img">
									<?= Html::img('@web/' .$model->thumbnail, ['alt'=>$model->name, 'class'=>'img-responsive product-photo']);?>
								</div>
							</div>
					</div>

					<div class="col-sm-4">
						<div class="alert alert-warning">

							<div class="form-group">
								<span class="lead text-white">Видимость товара</span>
							</div>

							<?= $form->field($model, 'bonus_show')->checkbox() ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Стоимость товара</span>
							</div>

							<?= $form->field($model, 'bonus') ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Категории товара</span>
							</div>

							<?= $form->field($model, 'cat')
										->dropDownList(
											$categoriesList,
											['prompt'=>'Категория']
										);
							?>

							<?= $form->field($model, 'manufacturer')
										->dropDownList(
											$manufacturersList,
											['prompt'=>'Производитель']
										);
							?>

						</div>
					</div>

					<div class="col-sm-12">
						<div class="alert alert-warning">
							<?= Html::submitButton($edit?'<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> ' . $model->name:'<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Сохранить новый товар', ['class' => 'btn btn-lg btn-warning center-block', 'name' => 'bonus-edit-button']) ?>
						</div>
					</div>

				<?php ActiveForm::end(); ?>

		</article><!-- /.office-bonus-edit -->
