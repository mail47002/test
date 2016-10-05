﻿<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Контакты: свяжитесь с администратором';
$this->params['breadcrumbs'][] = $this->title;
?>

		<article class="site-contact" itemscope itemtype="http://schema.org/Article">
			<div class="container">

				<h1><?= Html::encode($this->title) ?></h1>

				<div class="row">
					<div class="col-lg-5">
						<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

							<?= $form->field($model, 'name') ?>

							<?= $form->field($model, 'email') ?>

							<?= $form->field($model, 'subject') ?>

							<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

							<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
								'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
							]) ?>

							<div class="form-group">
								<?= Html::submitButton('<span class="glyphicon glyphicon-send" aria-hidden="true"></span> Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
							</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>

			</div><!-- /.container -->
		</article><!-- /.site-contact -->
