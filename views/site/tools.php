<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<a class="btn-info btn" href="<?=Url::to(['regtype/reglist']);?>"><i class="fa fa-arrows"></i> รูปแบบพัสดุ</a>
<a class="btn-info btn" href="<?=Url::to(['staff/stafflist']);?>"><i class="fa fa-users"></i> เพิ่มstaff</a>
<a class="btn-info btn" href="<?=Url::to('site/index');?>"><i class="fa fa-university"></i> เพิ่มหน่วยงาน</a>
