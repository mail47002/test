<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-details-form">

    <?php $form = ActiveForm::begin(); ?>

		<div class="row">

			<div class="col-sm-8">

			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'implement')
						->dropDownList(
							$parentList
						);
			?>

			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать' : Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
				</div>
			</div>

		</div><!-- /.row -->

    <?php ActiveForm::end(); ?>

</div>
