<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Список моих продаж';
$this->params['breadcrumbs'][] = $this->title;

$status[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора. Не участвует в общем подсчете."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$status[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтверждено"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$status[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
// Ballance
$points = 0;
$total = 0;
?>

		<article class="office-seles-list" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<td class="text-info"><strong>ID</strong></td>
									<td class="text-info"><strong>Модель</strong></td>
									<td class="text-info"><strong>Дата продажи</strong></td>
									<td class="text-info"><strong>Статус</strong></td>
									<td class="text-info"><strong>Баллов</strong></td>
									<td class="text-info"><strong>Просмотр</strong></td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach( $model as $key => $sale ) {
								if( $sale['status'] != 10 ) {
									$sale['price'] = 0;
								}
								$points += $sale['price'];
							?>
								<tr>
									<td class="text-warning"><?php echo $key; ?></td>
									<td class="text-info">
										<a href="<?php echo Url::to(['/office/bonus/product-card-bonus/', 'id' => $sale['model_id']]); ?>"><?php echo $sale['model']; ?></a>
									</td>
									<td class="text-warning"><?php echo $sale['date']; ?></td>
									<td><?php echo $status[$sale['status']]; ?></td>
									<td class="text-primary"><?php echo $sale['price']; ?></td>
									<td>
										<a href="<?php echo Url::to(['/office/sales/view/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Просмотреть информацию о продаже"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
									</td>
								</tr>
							<?php
								}
							?>
								<tr>
									<td class="text-info" colspan="4"><strong>Всего баллов начислено:</strong></td>
									<td class="text-info" colspan="2"><strong><?php echo $points; ?></strong></td>
								</tr>
								<tr>
									<td class="text-warning" colspan="4"><strong>Списано на подарки:</strong></td>
									<td class="text-warning" colspan="2"><strong><?php echo $total_gifts; ?></strong></td>
								</tr>
								<tr>
									<td class="text-success" colspan="4"><strong>Доступно для использования:</strong></td>
									<td class="text-success" colspan="2"><strong><?php echo $points - $total_gifts; ?></strong></td>
								</tr>
							</tbody>
						</table>
					</div>

		</article><!-- /.office-seles-list -->
