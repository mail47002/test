<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-complete', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здаравствуйте, <?= Html::encode($user->username) ?>.</p>

    <?= Html::encode($mail) ?>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>Если это письмо пришло к Вам ошибочно, просто игнорируйте его.</p>

</div>
