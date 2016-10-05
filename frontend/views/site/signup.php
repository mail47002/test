<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-signup" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($this->title) ?></h1>

				<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group">
							<span class="lead text-success">Личные данные</span>
						</div>

						<?= $form->field($model, 'lastname')->textInput(['placeholder' => 'Иванов']) ?>

						<?= $form->field($model, 'firstname')->textInput(['placeholder' => 'Иван']) ?>

						<?= $form->field($model, 'middlename')->textInput(['placeholder' => 'Иванович']) ?>


						<div class="form-group">
							<span class="lead text-success">Учетные данные</span>
						</div>

						<?= $form->field($model, 'username')->textInput(['placeholder' => 'Логин для входа в систему']) ?>

						<?= $form->field($model, 'email')->textInput(['placeholder' => 'Для уведомлений']) ?>

						<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Заглавные, строчные буквы, цифры, спецсимволы ']) ?>

						<?= $form->field($model, 'repassword')->passwordInput() ?>

						<?= $form->field($model, 'offer')->checkbox() ?>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<span class="lead text-success">Контактная информация</span>
						</div>
						<?= $form->field($model, 'district')
									->dropDownList(
										$districtList,
										['prompt'=>'Выберите область']
									);
						?>

						<?= $form->field($model, 'city')->textInput(['placeholder' => 'Ваш населенный пункт']) ?>

						<?= $form->field($model, 'phone')->textInput(['placeholder' => '0671112233']) ?>


						<div class="form-group">
							<span class="lead text-success">Профессиональная информация</span>
						</div>

						<?= $form->field($model, 'education')
									->dropDownList(
										$educationList,
										['prompt'=>'Выберите образование']
									);
						?>

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

						<?= $form->field($model, 'organization')->textInput(['placeholder' => 'Название организации']) ?>

						<?= $form->field($model, 'organization_address')->textInput(['placeholder' => 'Укажите адрес организации']) ?>

					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<?= Html::submitButton('<span class="glyphicon glyphicon-edit" aria-hidden="true"> Регистрация', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
						</div>
					</div>

				</div><!-- /.row -->
				<?php ActiveForm::end(); ?>

			</div><!-- /.container -->
		</article><!-- /.site-signup -->
