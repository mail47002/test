<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RatingSections */

$this->title = 'Обновить блок рейтинга: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блоки рейтинга', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="rating-sections-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
