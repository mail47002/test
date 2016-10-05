<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Здаравствуйте, <?= $user->username ?>.

<?= strip_tags($mail) ?>

Система дистанционного обучения: 213.169.78.29:8081

Учетные данные для входа
Логин: <?= $user->username ?>
Пароль: <?= $sdo_password ?>

Если это письмо пришло к Вам ошибочно, просто игнорируйте его.