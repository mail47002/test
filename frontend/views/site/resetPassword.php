<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-reset-password" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($this->title) ?></h1>

				<p>Введите новый пароль:</p>

				<div class="row">
					<div class="col-lg-6">
						<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

							<?= $form->field($model, 'password')->passwordInput() ?>

							<div class="form-group">
								<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"> Сохранить', ['class' => 'btn btn-primary']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>

			</div><!-- /.container -->
		</article><!-- /.site-reset-password -->
