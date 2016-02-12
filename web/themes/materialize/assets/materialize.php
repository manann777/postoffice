<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace app\web\themes\materialize\assets;
use yii\web\AssetBundle;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class materialize extends AssetBundle
{
   
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    //'css/site.css',
    'themes/materialize/css/materialize.css',
    'css/app.css',
    'themes/materialize/font/font-awesome-4.3.0/css/font-awesome.css',
    'https://fonts.googleapis.com/icon?family=Material+Icons',
   

    ];
    public $js = [
    'themes/materialize/js/materialize.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 


    ];
}
