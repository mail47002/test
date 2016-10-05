<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Зарегистрированная продажа ' . $model->model;
$this->params['breadcrumbs'][] = $this->title;

$status[1] = '<span class="text-warning" data-toggle="tooltip" data-placement="top" title="Ожидает проверки администратора. Не участвует в общем подсчете."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span></span>';
$status[10] = '<span href="#" class="text-success" data-toggle="tooltip" data-placement="top" title="Подтверждено"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
$status[0] = '<span href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Отклонено"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>';
?>

		<article class="office-seles-view" itemscope itemtype="http://schema.org/Article">

				<h1><?= Html::encode($this->title) ?></h1>
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="table-responsive">
							<table class="table table-striped">
									<tr>
										<td>Идентификатор</td>
										<td class="text-primary"><?php echo $model->id; ?></td>
									</tr>
									<?php
										if( $admin_mode ) {
									?>
									<tr>
										<td>Продавец</td>
										<td class="text-primary">
											<a href="<?php echo Url::to(['/office/profile/view/', 'id' => $model->user_id]); ?>"><?php echo $username ?></a>
										</td>
									</tr>
									<?php
										}
									?>
									<tr>
										<td>Модель устройства</td>
										<td class="text-primary">
											<a href="<?php echo Url::to(['/office/bonus/product-card-bonus/', 'id' => $product->id]); ?>"><?php echo $product->name; ?></a>
										</td>
									</tr>
									<tr>
										<td>EMEI</td>
										<td class="text-primary"><?php echo $model->emei1; ?></td>
									</tr>
									<tr>
										<td>EMEI</td>
										<td class="text-primary"><?php echo $model->emei2; ?></td>
									</tr>
									<tr>
										<td>Серийный номер</td>
										<td class="text-primary"><?php echo $model->serial; ?></td>
									</tr>
									<tr>
										<td>Дата продажи</td>
										<td class="text-primary"><?php echo $model->date; ?></td>
									</tr>
									<tr>
										<td>Статус</td>
										<td class="text-primary"><?php echo $status[$model->status]; ?></td>
									</tr>
									<tr>
										<td>Начислено баллов</td>
										<td class="text-primary"><?php echo $model->price; ?></td>
									</tr>
							</table>
						</div>

					</div>

					<div class="col-sm-12 col-md-6">

						<?php if( $model->img != '' ) { ?>
							<?= Html::img('@web/uploads/sales/' .$model->img, ['alt'=>$model->model, 'class'=>'img-responsive user-photo']);?> 
						<?php  } ?>

					</div>

					<?php
						if( $admin_mode && $model->status == 1 ) {
					?>
					<div class="col-sm-12">

						<div class="alert alert-warning">
							<div class="row">
								<div class="hidden-xs hidden-sm col-md-4">
									<span class="lead">Управление продажей</span>
								</div>
								<div class="col-xs-6 col-md-4">
									<a href="<?php echo Url::to(['/office/sales/proof/', 'id' => $model->id]); ?>" class="btn btn-warning center-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Подтвердить<span class="hidden-xs"> регистрацию</span></a>
								</div>
								<div class="col-xs-6 col-md-4">
									<a href="<?php echo Url::to(['/office/sales/reject/', 'id' => $model->id]); ?>" class="btn btn-warning center-block"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Отклонить<span class="hidden-xs"> регистрацию</span></a>
								</div>
							</div>
						</div>

					</div>
					<?php
						}
					?>

				</div><!-- /.row -->
		</article><!-- /.office-seles-view -->
