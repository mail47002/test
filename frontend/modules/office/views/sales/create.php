<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sales */

$this->title = 'Зарегистрировать продажу';
$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'productsList' => $productsList,
    ]) ?>

</div>
