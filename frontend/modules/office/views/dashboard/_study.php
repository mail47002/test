<?php

?>
					<div class="dashboard-notify study-nitify">
						<div class="alert alert-warning"> 
							<div class="row">

									<div class="notify-lable hidden-xs hidden-sm col-md-2">
										<span class="glyphicon glyphicon-education pull-left" aria-hidden="true"></span>
									</div>

									<div class="col-sm-6 col-md-7">
										<span class="value text-uppercase">Обучение</span>
										<hr>
										<span class="remarka">Вам необходимо пройти обучение. Без успешно пройденного обучения Вы не сможете регистрировать продажи и получать подарки.</span>
									</div>

									<div class="col-sm-6 col-md-3 text-center"> 
										<a href="/office/user-test/index.html" class="btn btn-lg btn-warning" role="button">Пройти<br>обучение</a>
									<p>Логин: <?= $username ?><br>
									ID: <?= $userid ?></p>
								</div>

							</div><!-- /.row -->
						</div><!-- /.alert -->
					</div><!-- /.study-notify -->