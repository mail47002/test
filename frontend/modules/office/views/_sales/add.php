<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('@web/js/sale-register-form.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Регистрация продажи';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="office-sale-registration" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

				<?php $form = ActiveForm::begin(['id' => 'form-sale-registration','options' => ['enctype'=>'multipart/form-data', 'class' => 'sale-registration', 'name' => 'sale-registration']]); ?>

				<div class="row">
					<div class="col-sm-12 col-md-6">

							<?= $form->field($model, 'model')
										->dropDownList(
											$productsList,
											['prompt'=>'Выберите модель']
										);
							?>

							<?= $form->field($model, 'emei1') ?>

							<?= $form->field($model, 'emei2') ?>

							<?= $form->field($model, 'serial') ?>

							<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
								'language' => 'ru',
								'dateFormat' => 'dd.MM.yyyy',
								'options' => ['class' => 'form-control'],
								'clientOptions' => ['defaultDate' => null],
							]) ?>

							<?= $form->field($model, 'img')->fileInput() ?>

							<div class="form-group">
								<?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary', 'name' => 'sale-registration-button']) ?>
							</div>

					</div>
				</div>

				<?php ActiveForm::end(); ?>

		</article><!-- /.office-sale-registration -->