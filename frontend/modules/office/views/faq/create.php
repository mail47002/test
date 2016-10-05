<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Создать раздел справки';
$this->params['breadcrumbs'][] = ['label' => 'Справка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'new' => true,
        'model' => $model,
		'tax' => $tax,
    ]) ?>

</div>
