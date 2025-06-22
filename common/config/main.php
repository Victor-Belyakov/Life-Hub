<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'assignmentTable' => 'auth_assignment',
        ],
        'i18n' => [
            'translations' => [
                'yii*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'yii' => 'yii.php',
                        'yii/grid' => 'grid.php',
                    ],
                ],
            ],
        ],
        's3' => [
            'class' => 'common\components\S3Component',
            'key' => 'YANDEX_KEY',
            'secret' => 'YANDEX_SECRET',
            'region' => 'us-east-1',
            'bucket' => 'your-bucket-name',
        ],
    ],
    'language' => 'ru-RU',
];
