<?php
use yii\web\View;
use app\assets\AppAsset;
AppAsset::register($this);

 $this->title = 'GAD POSTOFFICE::แก้ไขข้อมูล'; ?>
<h4>แก้ไขข้อมูล</h4>
<?php 
if($grouptype != 'airmailbkk'){
echo $this->render('_form',['model'=> $model,'setoff'=>$setoff]); 
}else{
echo $this->render('_formbkk',['model'=> $model,'setoff'=>$setoff]); 

}
?>
