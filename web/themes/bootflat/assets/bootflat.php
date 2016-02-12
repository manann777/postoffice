<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace app\web\themes\bootflat\assets;
use yii\web\AssetBundle;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class bootflat extends AssetBundle
{
   
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
   
   
    'themes/bootflat/fonts/font-awesome-4.3.0/css/font-awesome.css',
    'themes/bootflat/bootflat/css/bootflat.css',
    'vendor/sweetalert/dist/sweetalert.css',
    'vendor/selectize.js-master/dist/css/selectize.bootstrap3.css',
    'css/app.css',
    'js/FloatingActionButton/dist/css/kc.fab.css'

    ];
    public $js = [
     'themes/bootflat/js/bootstrap.min.js',
     'vendor/sweetalert/dist/sweetalert.min.js',
     'js/DataTables-master/media/js/jquery.dataTables.js',
     'js/DataTables-master/media/js/dataTables.bootstrap.js',
     'js/table2excel/src/jquery.table2excel.js',
     //'vendor/selectize.js-master/dist/js/standalone/selectize.js',
     'js/gadpostoffice.js',
     'js/FloatingActionButton/dist/js/kc.fab.js',
     'js/floating.js'
     //'js/selectizecontrol.js',
     
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 


    ];
}
