					<div class="col-sm-12 profile-notify">
						<div class="alert alert-success">
							<div class="row">

								<div class="notify-lable hidden-xs hidden-sm col-md-2">
									<span class="glyphicon glyphicon-stats pull-left" aria-hidden="true"></span>
								</div>

								<div class="col-sm-6 col-md-5">
									<span class="glyphicon glyphicon-star-empty pull-right" aria-hidden="true"></span>
									<span class="value"><?= $count_bonuses ?></span>
									<span class="title text-uppercase">Зарегистрировано продаж</span>
									<hr>
									<span class="remarka">Получено баллов: <?= $total_bonuses ?></span>
								</div>

								<div class="col-sm-6 col-md-5">
									<span class="glyphicon glyphicon-gift pull-right" aria-hidden="true"></span>
									<span class="value"><?= $count_gifts ?></span>
									<span class="title text-uppercase">Получено подарков</span>
									<hr>
									<span class="remarka">Использовано баллов: <?= $total_gifts ?></span>
								</div>

							</div><!-- /.row -->
						</div><!-- /.alert -->
					</div><!-- /.profile-notify -->