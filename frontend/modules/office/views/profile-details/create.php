<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProfileDetails */

$this->title = 'Создать параметр профиля';
$this->params['breadcrumbs'][] = ['label' => 'Параметры профиля', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'parentList' => $parentList,
    ]) ?>

</div>
