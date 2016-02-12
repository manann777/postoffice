<?php 
use yii\helpers\Html;
use yii\helpers\Url;



echo Html::beginForm(Url::to(['login']),'post');
echo Html::input('text','email');
echo Html::input('submit');

echo Html::endForm();
?>