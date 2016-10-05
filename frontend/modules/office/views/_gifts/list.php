<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Управление подарками';
$this->params['breadcrumbs'][] = $this->title;

$status[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
$status[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$status[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтвержден. Ожидает выдачи."><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$status[20] = '<span href="#" class="text-primary" data-toggle="tooltip" data-placement="top" title="Подарок выдан"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></span>';

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
									<td class="text-info"><strong>Дата регистрации</strong></td>
									<td class="text-info"><strong>Статус</strong></td>
									<td class="text-info"><strong>Баллов</strong></td>
									<td class="text-info" colspan="3"><strong>Управление</strong></td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach( $model as $key => $gift ) {
							?>
								<tr>
									<td class="text-warning"><?php echo $key; ?></td>
									<td class="text-success">
										<a href="<?php echo Url::to(['/office/bonus/product-card-gift/', 'id' => $gift['model_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку подарка"><?php echo $gift['model']; ?></a>
									</td>
									<td class="text-success">
										<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $gift['user_id']]); ?>" data-toggle="tooltip" data-placement="top" title="Просмотреть профиль пользователя"><?php echo $gift['user_name'] ?></a>
									</td>
									<td class="text-warning"><?php echo $gift['created_at']; ?></td>
									<td><?php echo $status[$gift['status']]; ?></td>
									<td class="text-warning"><?php echo $gift['price']; ?></td>
									<?php
										if( $gift['status'] == 10 ) {
									?>
									<td colspan="2">
										<a href="<?php echo Url::to(['/office/gifts/givenout/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Пометить как выданный"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
									</td>
									<?php
										} else if( $gift['status'] == 20 ) {
									?>
									<td colspan="2">
									</td>
									<?php
										} else {
									?>
									<td>
										<a href="<?php echo Url::to(['/office/gifts/proof/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Подтвердить регистрацию продажи"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
									</td>
									<td>
										<a href="<?php echo Url::to(['/office/gifts/reject/', 'id' => $key]); ?>" class="control-link text-info" data-toggle="tooltip" data-placement="top" title="Отклонить регистрацию продажи"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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
