<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Mail */

$this->title = 'Обновить уведомление: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Почтовые уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="mail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
