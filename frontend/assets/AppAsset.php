<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap5\BootstrapAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
        'css/color.css',
        'css/calendar.css',
    ];

    public $js = [
        'js/site.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}
