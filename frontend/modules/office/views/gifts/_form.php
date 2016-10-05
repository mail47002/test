<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gifts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gifts-form">

		<?php $form = ActiveForm::begin(); ?>

		<div class="row">

			<div class="col-sm-8">

				<?= $form->field($model, 'model')->radioList($prizesList) ?>

			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<?= Html::submitButton(Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Выбрать подарок' , ['class' => 'btn btn-info']) ?>
				</div>
			</div>

		</div><!-- /.row -->

		<?php ActiveForm::end(); ?>

</div>
