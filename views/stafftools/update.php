<?php
use yii\web\View;
use app\assets\AppAsset;
AppAsset::register($this);

 $this->title = 'GAD POSTOFFICE::แก้ไขข้อมูล'; ?>
<h4>แก้ไขข้อมูล</h4>
<?php 
echo $this->render('_form',['model'=> $model,'setoff'=>$setoff]); 
?>