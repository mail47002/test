<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
						<div class="row">

							<div class="col-sm-6 dashboard-notify">
								<a class="alert alert-success link-block" href="<?php echo Url::to(['/office/sales/archive']); ?>" title="Просмотреть список зарегистрированных продаж">
									<span class="glyphicon glyphicon-star-empty pull-right" aria-hidden="true"></span>
									<span class="value"><?= $count_bonuses ?></span>
									<span class="title text-uppercase">Зарегистрировано продаж</span>
									<hr>
									<span class="remarka">Получено баллов: <?= $total_bonuses ?></span>
								</a>
							</div>

							<div class="col-sm-6 dashboard-notify">
								<a class="alert alert-warning link-block" href="<?php echo Url::to(['/office/gifts/archive']); ?>" title="Просмотреть список полученных подарков">
									<span class="glyphicon glyphicon-gift pull-right" aria-hidden="true"></span>
									<span class="value"><?= $count_gifts ?></span>
									<span class="title text-uppercase">Получено подарков</span>
									<hr>
									<span class="remarka">Использовано баллов: <?= $total_gifts ?></span>
								</a>
							</div>

						</div><!-- /.row -->