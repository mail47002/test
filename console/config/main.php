<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'backup' => [
			'dumpCommands' => ['--single-transaction'],
            'class' => 'execut\backup\controllers\BackupController',
            'ftpDir' => 'smp_back_up',
            'ftpHost' => 'backup.smp.impression.ua',
            'ftpLogin' => 'backup.smp.impression.ua|smp',
            'ftpPassword' => 'smpNavigatorBackUp27905',
            /*'ftpHost' => '91.239.233.33',
            'ftpLogin' => 'fresco',
            'ftpPassword' => 'Fres34#$Co12',*/
			'folders' => [
				//'/var/www/html/frontend/web/uploads/dump_smp/files',
				//'/var/www/html/frontend/web/uploads/dump_smp/i',
			],
            'folderPrefix' => 'smp_db',
            /*'dbKeys' => [
                'db'
            ],*/
            'adminMail' => 'info@veselka.ua',
            'filePartSize' => '300MiB', // Split unix command part size
        ],
	],
    'params' => $params,
];
