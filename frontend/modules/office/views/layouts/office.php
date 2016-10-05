<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Collapse;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->registerJsFile('@web/js/canvas.js', ['depends' => 'yii\web\JqueryAsset']);
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
		'innerContainerOptions' => ['class' => 'container-fluid'],
    ]);
    $menuItems = [
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

	<div class="content-wrap container-fluid">
	<div class="row-offcanvas row-offcanvas-left">

		<p class="pull-left visible-xs">
			<button type="button" class="btn btn-info btn-xs" data-toggle="offcanvas">Меню</button>
		</p>

		<div id="aside" class="col-xs-6 col-sm-3 sidebar-offcanvas">

			<ul id="w4" class="nav nav-pills nav-stacked">
				<li>
					<a href="<?php echo Url::toRoute('/office/dashboard/index'); ?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Панель управления</a>
				</li>
				<li class="divider"></li>

			<?php
			// Кнопка обучения для продавцов не прошедших СДО
			if (\Yii::$app->user->identity->role == 6) { 
			?>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#study-menu">
						<span class="glyphicon glyphicon-education" aria-hidden="true"></span> Обучение 
						<b class="caret"></b>
					</a>
					<ul id="study-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute('/office/text/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Зачем проходить обучение</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/user-test/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Обучение</a>
						</li>
					</ul>
				</li>
			<?php
			}

			// Регистрация продаж и подарков для подавцов
			if (\Yii::$app->user->identity->role == 10 || \Yii::$app->user->identity->role == 12) {
			?>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#user-sales-menu">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Личные продажи 
						<b class="caret"></b>
					</a>
					<ul id="user-sales-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute('/office/sales/archive'); ?>" tabindex="-1"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Список продаж</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/sales/create'); ?>" tabindex="-1"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Регистрировать новую</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/gifts/archive'); ?>" tabindex="-1"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Мои подарки</a>
						</li>
					</ul>
				</li>
			<?php
			}

			// Вывод лент архивов бонусов и подарков
			if (\Yii::$app->user->identity->role >= 4 && \Yii::$app->user->identity->role <= 12) {
			?>
				<li>
					<a href="<?php echo Url::toRoute('/office/products/archive'); ?>"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Бонусы</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/prizes/archive'); ?>"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Подарки</a>
				</li>
			<?php
			}

			// Инструменты редактора
			if (\Yii::$app->user->identity->role == 16 || \Yii::$app->user->identity->role >= 36) {
			?>
				<li>
					<a href="<?php echo Url::toRoute('/office/page/index'); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Редактировать Cтраницы</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/news/index'); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Редактировать Новости</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/faq/index'); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Редактировать Справку</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/mail/index'); ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Почтовые сообщения</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/profile-details/index'); ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Параметры профиля</a>
				</li>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#products-menu">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Управление товарами 
						<b class="caret"></b>
					</a>
					<ul id="products-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute('/office/products/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Товары</a>
						</li> 
						<li>
							<a href="<?php echo Url::toRoute('/office/prizes/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Подарки</a>
						</li>
					</ul>
				</li>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#test-menu">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Управление тестами
						<b class="caret"></b>
					</a>
					<ul id="test-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute('/office/study/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Обучение</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/test/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Тесты</a>
						</li>
					</ul>
				</li>
			<?php
			}

			// Статистические инструменты для аналитиков
			if (\Yii::$app->user->identity->role == 21) {
			?>
				<li>
					<a href="<?php echo Url::toRoute('/office/dashboard/index'); ?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Статистика</a>
				</li>
			<?php
			}

			// Управление пользователями продажами и подарками для администраторов
			if (\Yii::$app->user->identity->role >= 36) {
			?>
				<li class="divider"></li>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#rating-sections-menu">
						<span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Управление рейтингом 
						<b class="caret"></b>
					</a>
					<ul id="rating-sections-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute('/office/rating/index'); ?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Круги рейтинга</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/rating-sections/index'); ?>"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Распределение мест</a>
						</li>
					</ul>
				</li>
				<li class="collapse">
					<a data-toggle="collapse" data-target="#sales-menu">
						<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Управление продажами 
						<b class="caret"></b>
					</a>
					<ul id="sales-menu" class="nav nav-pills nav-stacked collapse">
						<li>
							<a href="<?php echo Url::toRoute(['/office/sales/index', 'SalesSearch[condition]' => '1']); ?>" tabindex="-1"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Новые продажи</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute('/office/sales/index'); ?>" tabindex="-1"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Все продажи</a>
						</li>
						<li>
							<a href="<?php echo Url::toRoute(['/office/sales/index', 'SalesSearch[condition]' => '20']); ?>" tabindex="-1"><span class="glyphicon glyphicon-compressed" aria-hidden="true"></span> Архив</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/gifts/index'); ?>"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Управление подарками</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/user/index'); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Управление пользователями</a>
				</li>
			<?php
			}
			?>

				<li class="divider"></li>
				<li>
					<a href="<?php echo Url::toRoute('/office/user/rating'); ?>"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Рейтинг</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/faq/archive'); ?>"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> FAQ</a>
				</li>
				<li>
					<a href="<?php echo Url::toRoute('/office/news/archive'); ?>"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Новости</a>
				</li>
			</ul>
		</div><!-- /#aside -->

		<!-- Site content -->
		<section id="content" class="col-xs-12 col-sm-9">
			<?= Alert::widget() ?>
			<?= $content ?>

		</section><!-- /#content -->

	</div><!-- /.row-offcanvas -->
	</div><!-- /.content-wrap .container-fluid -->

</div><!-- #wrap -->

	<footer id="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
    <?php
    NavBar::begin([
        'brandLabel' => 'СМП',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default',
        ],
		'innerContainerOptions' => ['class' => 'container-fluid'],
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
			<div class="container-fluid">
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
			<div class="container-fluid">
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
