<?php 
use app\assets\AppAsset;
AppAsset::register($this);
use yii\web\View;
$this->title = 'GAD POSTOFFICE::เพิ่มข้อมูล'; ?>
<h4>เพิ่มข้อมูล</h4>
<?php


echo $this->render('_formbkk',['model'=>$model]);
/*
$this->registerJsFile('postoffice/web/js/selectizecontrol.js',['depends' => [\yii\web\JqueryAsset::className()]]);
*/

?>
