<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


/* @var $this yii\web\View */
/* @var $model common\models\Mail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-form">

    <?php $form = ActiveForm::begin(); ?>

		<div class="row">

			<div class="col-sm-8">

			<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'content')->widget(CKEditor::className(), [
				'editorOptions' =>
					ElFinder::ckeditorOptions('elfinder',[
						'preset' => 'standard',
						'uiColor' => '#b895c2',
					]),
			]) ?>

			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать' : Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
				</div>
			</div>

		</div><!-- /.row -->

    <?php ActiveForm::end(); ?>

</div>
