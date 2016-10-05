<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = $admin_mode?'Редактировать профиль: ' . ' ' . $model->firstname . ' ' . $model->lastname:'Редактирование своих данных';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname . ' ' . $model->lastname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_profile_form', [
        'model' => $model,
		'genderList' => $genderList,
		'districtList' => $districtList,
		'educationList' => $educationList,
		'subdivisionList' => $subdivisionList,
		'positionList' => $positionList,
		'categoryList' => $categoryList,
    ]) ?>

</div>