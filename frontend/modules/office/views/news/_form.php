<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

		<?php $form = ActiveForm::begin(['id' => 'form-news-edit','options' => ['enctype'=>'multipart/form-data', 'class' => 'news-edit', 'name' => 'news-edit']]); ?>

		<div class="row">

					<div class="col-sm-8">

							<?= $form->field($model, 'title') ?>

							<?= $form->field($model, 'excerpt')->widget(CKEditor::className(), [
								'editorOptions' =>
									ElFinder::ckeditorOptions('elfinder',[
										'preset' => 'basic',
										'uiColor' => '#b895c2',
									]),
							]) ?>

							<?= $form->field($model, 'content')->widget(CKEditor::className(), [
								'editorOptions' =>
									ElFinder::ckeditorOptions('elfinder',[
										'preset' => 'standard',
										'uiColor' => '#b895c2',
									]),
							]) ?>

							<?= $form->field($model, 'slug') ?>
					</div>

					<div class="col-sm-4">
						<div class="alert alert-warning">

							<div class="form-group">
								<span class="lead text-white">Видимость новости</span>
							</div>

							<?= $form->field($model, 'draft')->checkbox() ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Миниатюра новости</span>
							</div>


							<?= $form->field($model, 'img')->widget(InputFile::className(), [
								'language'      => 'ru',
								'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
								'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
								'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
								'options'       => ['class' => 'form-control'],
								'buttonOptions' => ['class' => 'btn btn-info'],
								'buttonName'	=> '<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>',
								'multiple'      => false,       // возможность выбора нескольких файлов
								
							]) ?>


							<?php
								if( $model->thumbnail != '' ) {
							?>
								<?= Html::img('@web/' .$model->thumbnail, ['alt'=>$model->title, 'class'=>'img-responsive news-photo']);?>
							<?php
								}
							?>

						</div>
					</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton($new ? (Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать') : (Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Обновить') , ['class' => $new ? 'btn btn-success' : 'btn btn-info']) ?>
				</div>
			</div>

		</div><!-- /.row -->

		<?php ActiveForm::end(); ?>

</div>
