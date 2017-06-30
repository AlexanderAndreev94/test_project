<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/blogstyle.css',
        'js/fancybox/jquery.fancybox-1.3.4.css',
    ];
    public $js = [
        //'js/login.js',
        //'js/reg.js'
       // 'js/jquery-1.4.3.min.js',
        'js/fancybox/jquery.fancybox-1.3.4.js',
        'js/fancybox/jquery.fancybox-1.3.4.pack.js',
        'js/fancybox/jquery.easing-1.3.pack.js',
        'js/fancybox/jquery.mousewheel-3.0.4.pack.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
