<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => [
				'verification',
				'proof',
				'sdo',
				'study',
				'seller',
				'senior_seller',
				'editor',
				'analyst',
				'admin',
				'god_mode',
			],
			'cache' => 'cache',
		],
		'assetManager' => [
			 'basePath' => '@webroot/assets',
			 'baseUrl' => '@web/assets',
		],
    ],
];
