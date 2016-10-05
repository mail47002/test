<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Gifts */

$this->title = 'Создать Gifts';
$this->params['breadcrumbs'][] = ['label' => 'Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gifts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
