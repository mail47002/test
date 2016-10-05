<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Изменить роль пользователя: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить профиль';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<div class="col-lg-6 user-form">

			<?php $form = ActiveForm::begin(); ?>

				<?= $form->field($model, 'role')
							->dropDownList(
								$rolesList
							);
				?>
			<div class="form-group">
				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? Html::tag('span','',['class' => 'glyphicon glyphicon-plus', 'aria-hidden' => 'true']) . ' Создать' : Html::tag('span','',['class' => 'glyphicon glyphicon-floppy-save', 'aria-hidden' => 'true']) . ' Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
				</div>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
