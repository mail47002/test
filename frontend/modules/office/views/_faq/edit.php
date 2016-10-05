<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->registerJsFile('@web/js/profile-edit.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = $edit?'Изменить справку ' . $model->title:'Добавить справку';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-faq-edit" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

				<?php $form = ActiveForm::begin(['id' => 'form-faq-edit','options' => ['enctype'=>'multipart/form-data', 'class' => 'faq-edit', 'name' => 'faq-edit']]); ?>

				<div class="row">
				
					<div class="col-sm-8">

							<?= $form->field($model, 'title') ?>

							<?= $form->field($model, 'excerpt')->textArea(['rows' => '3']) ?>

							<?= $form->field($model, 'content')->textArea(['rows' => '8']) ?>

							<?= $form->field($model, 'slug') ?>
					</div>

					<div class="col-sm-4">
						<div class="alert alert-warning">

							<div class="form-group">
								<span class="lead text-white">Видимость раздела справки</span>
							</div>

							<?= $form->field($model, 'draft')->checkbox() ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Категория справки</span>
							</div>

							<?= $form->field($model, 'category')
										->dropDownList(
											$tax
										);
							?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Миниатюра справки</span>
							</div>

							<?= $form->field($model, 'img')->fileInput() ?>

							<?php
								if( $model->thumbnail != '' ) {
							?>
								<?= Html::img($model->thumbnail, ['alt'=>$model->title, 'class'=>'img-responsive faq-photo']);?>
							<?php
								}
							?>

						</div>
					</div>

					<div class="col-sm-12">
						<div class="alert alert-warning">
							<?= Html::submitButton($edit?'<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> ' . $model->title:'<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Сохранить справку', ['class' => 'btn btn-lg btn-warning center-block', 'name' => 'faq-edit-button']) ?>
						</div>
					</div>

				<?php ActiveForm::end(); ?>

		</article><!-- /.office-faq-edit -->