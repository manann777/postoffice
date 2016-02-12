<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

 if(Yii::$app->session->hasFlash('warning')){
   echo Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('warning'), 'body'),
    'options'=>['class'=>'alert-danger']
    ]);
}

echo Html::beginForm(Url::to(['login']),'post');
echo Html::input('text','email');
echo Html::input('submit');

echo Html::endForm();
