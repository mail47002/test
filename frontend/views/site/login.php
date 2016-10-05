<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-login" itemscope itemtype="http://schema.org/Article">
			<div class="container" style="margin-top:10%;">

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" >

						<h1><?= Html::encode($this->title) ?></h1>

						<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

							<?= $form->field($model, 'username') ?>

							<?= $form->field($model, 'password')->passwordInput() ?>

							<div class="col-xs-6">
								<?= $form->field($model, 'rememberMe')->checkbox() ?>
							</div>
							<div class="col-xs-6" style="text-align:right; margin:10px 0">
								<?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
							</div>

							<div class="clearfix"></div>

							<div class="form-group" style="margin-top:20px;">
								<?= Html::submitButton('<span class="glyphicon glyphicon-log-in" aria-hidden="true"> Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>

			</div><!-- /.container -->
		</article><!-- /.site-login -->
