<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-form">

		<?php $form = ActiveForm::begin(['id' => 'form-sales-register','options' => ['enctype'=>'multipart/form-data', 'class' => 'sales-register', 'name' => 'sales-register']]); ?>

		<div class="row">

			<div class="col-sm-8">


				<?= $form->field($model, 'model')
							->dropDownList(
								$productsList,
								['prompt'=>'Выберите модель']
							);
				?>

				<?= $form->field($model, 'emei1')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'emei2')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
					'language' => 'ru',
					'dateFormat' => 'dd.MM.yyyy',
					'options' => ['class' => 'form-control'],
					'clientOptions' => ['defaultDate' => null],
				]) ?>

				<?= $form->field($model, 'img')->fileInput() ?>

			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton(Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать' , ['class' => 'btn btn-success']) ?>
				</div>
			</div>

		</div><!-- /.row -->

		<?php ActiveForm::end(); ?>

</div>
