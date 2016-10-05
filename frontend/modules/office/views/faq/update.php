<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Обновить справку: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Справка', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'new' => false,
        'model' => $model,
		'tax' => $tax,
    ]) ?>

</div>
