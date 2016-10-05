<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="proof-mail">
    <p>Здаравствуйте, <?= Html::encode($user->username) ?>.</p>

    <?= Html::encode($mail) ?>

	<p><a href="http://213.169.78.29:8081/" target="_blank" title="Система дистанционного обучения">Система дистанционного обучения</a></p>

	<p>Учетные данные для входа.<br>
	Логин: <?= Html::encode($user->username) ?><br>
	Пароль: <?= Html::encode($sdo_password) ?></p>
	
    <p>Если это письмо пришло к Вам ошибочно, просто игнорируйте его.</p>
</div>