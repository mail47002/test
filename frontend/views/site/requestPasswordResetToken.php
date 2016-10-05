<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Запрос восстановления пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-request-password-reset" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($this->title) ?></h1>

				<p>Введите регистрационный почтовый ящик.</p>

				<div class="row">
					<div class="col-lg-5">
						<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

							<?= $form->field($model, 'email') ?>

							<div class="form-group">
								<?= Html::submitButton('<span class="glyphicon glyphicon-send" aria-hidden="true"> Отправить', ['class' => 'btn btn-primary']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>

			</div><!-- /.container -->
		</article><!-- /.site-request-password-reset -->
