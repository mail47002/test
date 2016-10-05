<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'bootstrap' => ['debug'],/*
    'on beforeRequest' => function ($event) {
        if( \Yii::$app->params['maintenance'] ) {
			$route = ltrim($_SERVER['REQUEST_URI'], '/');
			$route = str_replace('.html', '', $route);
			$route = explode('/', $route);
			//var_dump($route);
			if( \Yii::$app->user->isGuest && in_array($route[0], ['signup','signup-complete','request-password-reset','password-reset']) ) {
				Yii::$app->catchAll = [
                    // force route if portal in maintenance mode
                    'site/maintenance',
                ];
			}
			if( !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role < 16 && $route[0] == 'office' ) {
				Yii::$app->catchAll = [
                    // force route if portal in maintenance mode
                    'site/maintenance',
                ];
			}
        }
    },*/
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'request' => [
			'baseUrl' => '',
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			// Disable index.php
			'showScriptName' => false,
			// Disable r= routes
			'enablePrettyUrl' => true,
			'suffix' => '.html',
			'rules' => [
				'' => 'site/index',
				'<action>'=>'site/<action>',
				//'/exchange/profile.xml/*' => '/exchange/index.html',
				[
					'pattern' => 'exchange/profile',
					'route' => 'exchange/index',
					'suffix' => '.xml',
				],
			],
		],
    ],
	'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'http://smp.impression.ua',
                    'basePath'=>'@frontend/web',
                    'path' => 'uploads/post',
                    'name' => 'Записи'
                ],
                /*[
                    'class' => 'mihaildev\elfinder\volume\UserPath',
                    'path'  => 'uploads/user/user_{id}',
                    'name'  => 'Мои файлы'
                ],*/
                /*[
                    'baseUrl'=>'@web',
                    'basePath'=>'@frontend/web',
                    'path' => 'uploads/sales',
                    'name' => 'Продажи',
					'access' => ['read' => '*', 'write' => 'seller']
                ],*/
            ],
        ],
        'prizes' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'http://smp.impression.ua',
                    'basePath'=>'@frontend/web',
                    'path' => 'uploads/prizes',
                    'name' => 'Призы'
                ],
            ],
        ],
        'products' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'http://smp.impression.ua',
                    'basePath'=>'@frontend/web',
                    'path' => 'uploads/products',
                    'name' => 'Товары'
                ],
            ],
        ]
    ],
	/*'request'=>[
		'class' => 'common\components\Request',
		'web'=> '/frontend/web'
	],*/
	'modules' => [
		'office' => [
			'class' => 'frontend\modules\office\Dashboard',
		],
        'debug' => [
			'class' => 'yii\debug\Module',
			'allowedIPs' => ['127.0.0.1', '::1', '213.231.5.163', '213.231.4.249', '195.138.89.254', '176.241.152.102'], // adjust this to your needs
		],
	],
    'params' => $params,
];