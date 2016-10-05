<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Prizes */

$this->title = 'Создать подарок';
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prizes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'new' => true,
        'model' => $model,
		'categoriesList' => $categoriesList,
		'manufacturersList' => $manufacturersList,
    ]) ?>

</div>
