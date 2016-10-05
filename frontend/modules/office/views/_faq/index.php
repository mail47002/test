<?php

use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Справка отсутствует';
$this->params['breadcrumbs'][] = $this->title;

?>
			<div class="office-faq-index" >
				<h1><?= Html::encode($this->title) ?></h1>
				<div class="alert alert-warning">
						<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						<span> К сожалению для Вашего типа пользователя еще нет ни одного раздела справки. Если у Вас возникли вопросы, обратитесь к администратору.</span>
				</div>
			</div><!-- /.office-faq-index -->