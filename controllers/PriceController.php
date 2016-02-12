<?php

namespace app\controllers;
use app\models\EmsTb;
use app\models\Regmail;
use app\models\Manmail;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PriceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionGetprice($weight,$type)
    {	
    	switch($type){
        case 'ems': $sql ="SELECT price_rank FROM ems_tb WHERE ".$weight." BETWEEN min_weight AND max_weight";
    	$model = Emstb::findBySql($sql)->one(); 
        break;
        case 'regmail':
        $sql ="SELECT price_rank FROM regmail WHERE ".$weight." BETWEEN min_weight AND max_weight";
        $model = Regmail::findBySql($sql)->one(); 
        break;
        case 'emsact': $sql ="SELECT price_rank,AR FROM ems_tb WHERE ".$weight." BETWEEN min_weight AND max_weight";
        $model = Emstb::findBySql($sql)->one();
        $model->price_rank = ($model->price_rank)+($model->AR);
        break;
         case 'manmail': $sql ="SELECT price_rank FROM manmail WHERE ".$weight." BETWEEN min_weight AND max_weight";
        $model = Manmail::findBySql($sql)->one(); 
        break;
        case 'regmailact':
        $sql ="SELECT price_rank,AR FROM regmail WHERE ".$weight." BETWEEN min_weight AND max_weight";
        $model = Regmail::findBySql($sql)->one();
        $model->price_rank = ($model->price_rank)+($model->AR); 
        break;

        }
       
        if($type != 'airmail'){
    	$listData = ArrayHelper::toArray($model);
	    $jsonListdata = json_encode($listData);
        echo $jsonListdata;
       }else{
        $listData = ['price_rank'=>0];
        $jsonListdata = json_encode($listData);
        echo $jsonListdata;
       }

    		 
    }

}
