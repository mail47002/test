<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = 'Создать товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'new' => true,
        'model' => $model,
		'categoriesList' => $categoriesList,
		'manufacturersList' => $manufacturersList,
    ]) ?>

</div>
