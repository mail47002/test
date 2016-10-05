<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Mail */

$this->title = 'Создать почтовое уведомление';
$this->params['breadcrumbs'][] = ['label' => 'Уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
