<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-complete', 'token' => $user->password_reset_token]);
?>
Здаравствуйте, <?= $user->username ?>.

<?= strip_tags($mail) ?>

<?= $resetLink ?>

Если это письмо пришло к Вам ошибочно, просто игнорируйте его.