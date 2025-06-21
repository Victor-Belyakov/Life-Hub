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
    ],
    'language' => 'ru-RU',
];
