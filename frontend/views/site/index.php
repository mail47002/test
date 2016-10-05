<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Система мотивации продавцов';
?>

		<article class="home-page" itemscope itemtype="http://schema.org/Article">

			<div class="jumbotron">
				<div class="container">
<?= $slide->content ?>
						<div class="row jumbotron-btn">
							<div class="col-xs-6">
								<?= Html::a('Регистрация', ['site/signup'], ['class' => 'btn btn-lg btn-warning', 'role' => 'button']) ?>
							</div>
							<div class="col-xs-6">
								<p><?= Html::a('Вход', ['site/login'], ['class' => 'btn btn-lg white-link', 'role' => 'button']) ?></p>
							</div>
						</div><!-- /.row -->
				</div><!-- /.container -->
			</div><!-- /.jumbotron -->

			<div class="marketing">
				<div class="container">
						<div class="row jumbotron-btn">

							<div class="col-lg-6">
<?= $left->content ?>
							</div>

							<div class="col-lg-6">
<?= $right->content ?>
							</div>

						</div><!-- /.row -->
				</div><!-- /.container -->
			</div><!-- /.marketing -->

		</article><!-- /.home-page -->
