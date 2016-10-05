<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

		<?php $form = ActiveForm::begin(['id' => 'form-prizes-register','options' => ['enctype'=>'multipart/form-data', 'class' => 'prizes-register', 'name' => 'prizes-register']]); ?>

		<div class="row">

					<div class="col-sm-8">

							<?= $form->field($model, 'name') ?>

							<?= $form->field($model, 'excerpt')->widget(CKEditor::className(), [
								'editorOptions' =>
									ElFinder::ckeditorOptions('products',[
										'preset' => 'basic',
										'uiColor' => '#b895c2',
									]),
							]) ?>

							<?= $form->field($model, 'description')->widget(CKEditor::className(), [
								'editorOptions' =>
									ElFinder::ckeditorOptions('products',[
										'preset' => 'standard',
										'uiColor' => '#b895c2',
									]),
							]) ?>

							<?= $form->field($model, 'url') ?>


					</div>

					<div class="col-sm-4">
						<div class="alert alert-warning">

							<div class="form-group">
								<span class="lead text-white">Видимость товара</span>
							</div>

							<?= $form->field($model, 'draft')->checkbox() ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Эквивалент</span>
							</div>

							<?= $form->field($model, 'bonus') ?>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Категория товара</span>
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

					<div class="col-sm-4">
						<div class="well well-lg">

							<div class="form-group">
								<span class="lead text-success">Миниатюра товара</span>
							</div>


							<?= $form->field($model, 'img')->widget(InputFile::className(), [
								'language'      => 'ru',
								'controller'    => 'products', // вставляем название контроллера, по умолчанию равен elfinder
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
								<?= Html::img('@web/' .$model->thumbnail, ['alt'=>$model->name, 'class'=>'img-responsive product-photo']);?>
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