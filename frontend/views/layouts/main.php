<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="author" content="veselka.ua">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.png" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body itemscope="" itemtype="http://schema.org/WebPage" data-spy="scroll">
<?php $this->beginBody() ?>

<div id="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'СМП',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'О системе', 'url' => ['/site/about']],
        ['label' => 'Контакты', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
		$menuItems[] = ['label' => 'Панель управления', 'url' => ['/office/dashboard/index']];
		$menuItems[]=[
			'label' => Yii::$app->user->identity->username,
			'items' => [
				['label' => 'Профиль пользователя', 'url' => ['/office/user/viewinfo']],
				['label' => 'Изменить персональные данные', 'url' => ['/office/user/changeprofile']],
				['label' => 'Изменить пароль', 'url' => ['/office/user/password']],
				['label' => 'Выход', 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
			],
			
		];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

	<header id="header" itemscope itemtype="http://schema.org/WPHeader">
		<div class="container">
			<div id="masthead" class="clearfix">
				<div class="row">
					<div class="col-sm-4 col-md-3 col-lg-3">
						<div id="logo" class="row">
							<div class="col-xs-6 col-sm-12">
								<img class="img-responsive" src="/frontend/web/img/logo.jpg" alt="Система мотивации персонала - Impression">
							</div>
							<div class="col-xs-6 col-sm-12">
								<span class="logo-title text-info text-uppercase">Система мотивации персонала</span>
							</div>
						</div>
					</div>
					<div class="col-sm-5 col-md-4 col-lg-3">
						<div class="text-center complex-info complex-phone header-phone">
							<div class="complex-wrap">
								<div class="complex-ico pull-left text-success"><span class="glyphicon glyphicon-earphone"></span></div>
								<div class="complex-text pull-right"><span class="text-nowrap"><a href="tel:+380800303009">0-800 30-30-09</a></span></div>
								<div class="complex-remarka text-muted"><span class="pull-left">с 10:00 до 18:00</span><span class="pull-right">Сб-Вс: выходные</span></div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-md-offset-1 col-lg-2 col-lg-offset-2">
						<div class="text-center complex-info complex-liner header-login">
							<div class="complex-wrap">
								<div class="complex-ico pull-left text-success"><span class="glyphicon glyphicon-log-in"></span></div>
								<div class="complex-text pull-right"><?= Html::a('Авторизация', ['site/login']) ?></div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
						<div class="text-center complex-info complex-liner header-question">
							<div class="complex-wrap">
								<div class="complex-ico pull-left text-success"><span class="glyphicon glyphicon-question-sign"></span></div>
								<div class="complex-text pull-right"><?= Html::a('Задать вопрос', ['site/contact']) ?></div>
							</div>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /#masthead -->
			<meta itemprop="headline" content="Система мотивации персонала" />
			<meta itemprop="description" content="Система мотивации персонала" />
		</div><!-- /.container -->
	</header><!-- #site-header -->

    <div class="container">
        <?= Breadcrumbs::widget([
			'homeLink'=> [ 
				'label' => 'СМП',
				'url' => Yii::$app->homeUrl,
			],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
    </div><!-- /.container -->


	<!-- Site content -->
	<section id="content">
        <?= $content ?>

	</section><!-- #content -->


</div><!-- #wrap -->

	<footer id="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
    <?php
    NavBar::begin([
        'brandLabel' => 'СМП',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'О системе', 'url' => ['/site/about']],
        ['label' => 'Контакты', 'url' => ['/site/contact']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
		<div id="footer-content">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-4 col-lg-3">
						<div class="text-center complex-info complex-phone footer-phone">
							<div class="complex-wrap">
								<div class="complex-ico pull-left text-success"><span class="glyphicon glyphicon-earphone"></span></div>
								<div class="complex-text pull-right"><span class="text-nowrap"><a href="tel:+380800303009">0-800 30-30-09</a></span></div>
								<div class="complex-remarka text-muted"><span class="pull-left">с 10:00 до 18:00</span><span class="pull-right">Сб-Вс: выходные</span></div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-4 col-lg-3">
						<div class="text-center complex-info complex-liner footer-email">
							<div class="complex-wrap">
								<div class="complex-ico pull-left text-success"><span class="glyphicon glyphicon-envelope"></span></div>
								<div class="complex-text pull-right"><a href="mailto:smp@impression.ua">smp@impression.ua</a></div>
							</div>
						</div>
					</div>
					<div id="subscribe" class="col-sm-12 col-md-4 col-lg-3 col-lg-offset-3">
						<div class="row">
							<div class="col-sm-6 col-md-12">
								<p class="text-uppercase">Есть&nbsp;вопросы? Получите&nbsp;информацию.</p>
							</div>
							<div class="col-sm-6 col-md-12">
								<p><a class="btn btn-md btn-primary" href="<?php echo Url::toRoute('/site/contact'); ?>" role="button">Контактная форма</a></p>
							</div>
						</div><!-- /.row -->
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /#footer-content -->

		<div id="footer-footer">
			<div class="container">
				<div class="row">
					<div id="copywrites" class="col-sm-6">
						<span>&copy;&nbsp;1997&nbsp;-&nbsp;<?php echo date('Y') ?>&nbsp;"Impression&nbsp;Electronics". All&nbsp;rights&nbsp;reserved.</span>
					</div>
					<div id="developer" class="col-sm-6">
						<span>Developed by spiral</span>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /#footer-footer -->

	</footer><!-- #footer -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
