<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="common-mail">
    <p>Учетная запись <?= Html::encode($user->username) ?>.</p>

    <?= Html::encode($mail) ?>

</div>