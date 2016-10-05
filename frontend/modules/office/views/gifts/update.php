<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gifts */

$this->title = 'Выбрать подарок #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="gifts-update">

    <h1><?= Html::encode($this->title) ?></h1>

		<p class="text-success"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <span>Вы заняли <?= $model->place ?> место в рейтинге продавцов.</span></p>
		<p class="text-warning"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> <span>Вы получили подарок на сумму: <?= $taxonomy->name ?>.</span></p>

    <?= $this->render('_form', [
        'model' => $model,
		'prizesList' => $prizesList,
    ]) ?>

</div>
