<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-change-password" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($this->title) ?></h1>

				<p>Введите новый пароль:</p>

				<div class="row">
					<div class="col-md-6">
						<?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

							<?= $form->field($model, 'password')->passwordInput() ?>

							<?= $form->field($model, 'repassword')->passwordInput() ?>

							<div class="form-group">
								<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>

			</div><!-- /.container -->
		</article><!-- /.site-change-password -->
