<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RatingSections */

$this->title = 'Создать блок рейтинга';
$this->params['breadcrumbs'][] = ['label' => 'Блоки рейтинга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rating-sections-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
