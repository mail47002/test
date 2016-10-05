<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Список моих подарков';
$this->params['breadcrumbs'][] = $this->title;

$status[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
$status[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$status[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Выдача подарка подтверждена"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$status[20] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подарок выдан"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span></span>';
// Ballance

?>

		<article class="office-gifts-index" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<td class="text-info"><strong>ID</strong></td>
									<td class="text-info"><strong>Модель</strong></td>
									<td class="text-info"><strong>Дата регистрации</strong></td>
									<td class="text-info"><strong>Статус</strong></td>
									<td class="text-info"><strong>Баллов</strong></td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach( $model as $key => $gift ) {
							?>
								<tr>
									<td class="text-warning"><?php echo $key; ?></td>
									<td class="text-success">
										<?php echo $gift['model']; ?>

									</td>
									<td class="text-warning"><?php echo $gift['created_at']; ?></td>
									<td><?php echo $status[$gift['status']]; ?></td>
									<td class="text-warning"><?php echo $gift['price']; ?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>

		</article><!-- /.office-gifts-index -->
