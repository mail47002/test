<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'bootstrap' => ['debug'],
    'bootstrap' => ['gii'],
	'homeUrl' => '/admin',
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
			'baseUrl' => '/admin',
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
			],
		],
    ],
    'modules' => [
        'gii' => [
			'class' => 'yii\gii\Module',
			'allowedIPs' => ['127.0.0.1', '::1', '213.231.5.163', '213.231.4.249', '195.138.89.254', '176.241.152.102'], // adjust this to your needs
		],
        'debug' => [
			'class' => 'yii\debug\Module',
			'allowedIPs' => ['127.0.0.1', '::1', '213.231.5.163', '213.231.4.249', '195.138.89.254', '176.241.152.102'], // adjust this to your needs
		],
    ],
    'params' => $params,
];
