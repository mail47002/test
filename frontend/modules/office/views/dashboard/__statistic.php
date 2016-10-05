<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
				<h2>Статистика СМП</h2>
				<div class="row">
					<div class="col-sm-6 dashboard-notify">
						<a class="alert alert-warning link-block" href="<?php echo Url::to(['/office/user/index', 'UserSearch[role]' => '10']); ?>" title="Перейти в управление пользователями">
							<span class="glyphicon glyphicon-user pull-right" aria-hidden="true"></span>
							<span class="value"><?= $users_sellers ?></span>
							<span class="title">Зарегистрировано продавцов</span>
						</a>
					</div>
					<div class="col-sm-6 dashboard-notify">
						<a class="alert alert-danger link-block" href="<?php echo Url::to(['/office/user/index', 'UserSearch[role]' => '6']); ?>" title="Перейти в управление пользователями">
							<span class="glyphicon glyphicon-education pull-right" aria-hidden="true"></span>
							<span class="value"><?= $users_study ?></span>
							<span class="title">Не пройдено обучение</span>
						</a>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6 dashboard-notify">
						<a class="alert alert-success link-block" href="<?php echo Url::to(['/office/sales/index']); ?>" title="Перейти на страницу управления продажами">
							<span class="glyphicon glyphicon-star-empty pull-right" aria-hidden="true"></span>
							<span class="value"><?= $total_sales ?></span>
							<span class="title">Зарегистрированных продаж</span>
						</a>
					</div>
					<div class="col-sm-6 dashboard-notify">
						<a class="alert alert-success link-block" href="<?php echo Url::to(['/office/gifts/index']); ?>" title="Перейти на страницу управления подарками">
							<span class="glyphicon glyphicon-gift pull-right" aria-hidden="true"></span>
							<span class="value"><?= $total_gifts ?></span>
							<span class="title">Выданных подарков</span>
						</a>
					</div>
				</div>