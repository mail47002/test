<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Управление продажами';
$this->params['breadcrumbs'][] = $this->title;

$status[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора. Не участвует в общем подсчете."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$status[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтверждено"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$status[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';

?>
		<article class="office-seles-list" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<td class="text-info"><strong>ID</strong></td>
									<td class="text-info"><strong>Модель</strong></td>
									<td class="text-info"><strong>Продавец</strong></td>
									<td class="text-info"><strong>Дата продажи</strong></td>
									<td class="text-info"><strong>Статус</strong></td>
									<td class="text-info"><strong>Баллов</strong></td>
									<td class="text-info" colspan="3"><strong>Управление</strong></td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach( $model as $key => $sale ) {
							?>
								<tr>
									<td class="text-warning"><?php echo $key; ?></td>
									<td class="text-success">
										<a href="<?php echo Url::to(['/office/bonus/product-card-bonus/', 'id' => $sale['model_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку бонуса"><?php echo $sale['model']; ?></a>
									</td>
									<td class="text-success">
										<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $sale['user_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя"><?php echo $sale['user_name'] ?></a>
									</td>
									<td class="text-warning"><?php echo $sale['date']; ?></td>
									<td><?php echo $status[$sale['status']]; ?></td>
									<td class="text-warning"><?php echo $sale['price']; ?></td>

									<td<?php echo $sale['status']==10?' colspan="2"':''; ?>>
										<a href="<?php echo Url::to(['/office/sales/view/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Просмотреть информацию о продаже"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
									</td>

									<?php
										if( $sale['status'] <= 1 ) {
									?>
									<td<?php echo $sale['status']==0?' colspan="2"':''; ?>>
										<a href="<?php echo Url::to(['/office/sales/proof/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Подтвердить регистрацию продажи"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
									</td>
									<?php
										}
									?>

									<?php
										if( $sale['status'] > 0 ) {
									?>
									<td>
										<a href="<?php echo Url::to(['/office/sales/reject/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Отклонить регистрацию продажи"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</td>
									<?php
										}
									?>

								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>

		</article><!-- /.office-seles-list -->
