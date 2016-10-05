<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileDetails */

$this->title = 'Обновить параметр: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Параметры профиля', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="profile-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'parentList' => $parentList,
    ]) ?>

</div>
