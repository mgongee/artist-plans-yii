<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'modules' => [
		'admin' => [
            'class' => 'app\modules\admin\Module'
        ]
	],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'FDGgdge434636#$42%@rgessdgsdwegxb',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
      /*  'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'urlManager' => [
			'suffix' => '/',
			'enablePrettyUrl' => true,
			'rules' => [
				'login' => 'site/login',
				'logout' => 'site/logout',
				'admin' => 'admin/default/index',
				'admin/<controller:\w+>' => 'admin/<controller>/index',
				'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
				'artist/<name:([0-9a-zA-Z\-]+)>' => 'site/singleartist',
				'<route:\w+>' => 'site/artist',
				'<route:\w+>/<year:\d+>' => 'site/artistplansforyear',
				'<route:\w+>/<year:\d+>/<month:\d+>' => 'site/artistplans',
				'<route:\w+>/<year:\d+>/<month:\w+>' => 'site/artistplans'
				//'zx<module:\w+>' => '<module>/default/index'
            ]
		],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
