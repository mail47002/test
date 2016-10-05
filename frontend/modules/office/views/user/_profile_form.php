<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

	<?php $form = ActiveForm::begin(['id' => 'form-profile-update','options' => ['enctype'=>'multipart/form-data', 'class' => 'profile-update', 'name' => 'profile-update']]); ?>
		<div class="row">
			<div class="col-sm-6">

				<div class="form-group">
					<span class="lead text-success">Личная информация</span>
				</div>

					<?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::classname(), [
												'dateFormat' => 'dd.MM.yyyy',
												'options' => ['class' => 'form-control'],
												'clientOptions' => ['defaultDate' => null],
											]) ?>

					<?= $form->field($model, 'gender')
								->dropDownList(
									$genderList
								);
					?>

				<div class="form-group">
					<span class="lead text-success">Контактная информация</span>
				</div>

					<?= $form->field($model, 'district')
								->dropDownList(
									$districtList
								);
					?>

					<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'phone')->textInput(['placeholder' => 'yyyxxxxxxx, где yyy - код оператора/города после +38']) ?>

			</div>
			<div class="col-sm-6">

				<div class="form-group">
					<span class="lead text-success">Профессиональная информация</span>
				</div>

					<?= $form->field($model, 'education')
								->dropDownList(
									$educationList,
										['prompt'=>'Выберите образование']
								);
					?>

					<?= $form->field($model, 'work_expiriance')->textInput() ?>

					<?= $form->field($model, 'company_expiriance')->textInput() ?>

					<?= $form->field($model, 'subdivision')
								->dropDownList(
									$subdivisionList,
										['prompt'=>'Выберите подразделение']
								);
					?>

					<?= $form->field($model, 'position')
								->dropDownList(
									$positionList,
										['prompt'=>'Выберите должность']
								);
					?>

					<?= $form->field($model, 'category')
								->dropDownList(
									$categoryList,
										['prompt'=>'Выберите категорию']
								);
					?>

					<?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'organization_address')->textInput(['maxlength' => true]) ?>

				<div class="form-group">
					<span class="lead text-success">Изображение</span>
				</div>

					<?= $form->field($model, 'img')->fileInput() ?>

			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton(Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Обновить', ['class' => 'btn btn-info']) ?>
				</div>
			</div>

		</div><!-- /.row -->

    <?php ActiveForm::end(); ?>

</div>
