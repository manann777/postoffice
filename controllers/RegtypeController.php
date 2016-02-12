<?php

namespace app\controllers;
use app\models\RegType;
use yii\helpers\ArrayHelper;
use Yii;
class RegtypeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCreate()
    {
    	$model = new regtype;
    	if(yii::$app->request->post()){
    		$model->load(Yii::$app->request->post());
    		if($model->save()){
    			//return $this->redirect(['reglist']);
                $reglist = regtype::find()->all();
    		  return $this->redirect(['reglist']);
            }
    	}
    	return $this->render('create',['model'=>$model]);
    }
    public function actionReglist()
    {
       

        $reglist = regtype::find()->all();
        return $this->render('reglist',['modelReglist'=> $reglist]);
    }
    public function actionReglistjson()
    {
       
        $reglist = regtype::find()->all();
        $listData=ArrayHelper::toArray($reglist);
        $jsonListdata = json_encode($listData);
        echo $jsonListdata;
    }
    
    public function actionUpdate($id)
    {
        $regfind = regtype::findOne($id);
        if(yii::$app->request->post()){
            $regfind->load(yii::$app->request->post());
            if($regfind->save()){
                return $this->redirect(['reglist']);
            }
        }
        return $this->render('update',['modelRegfind'=> $regfind]);
    }

    public function actionDelete($id)
    {
       
        $model = regtype::findOne($id);
            if($model->delete()){
                return $this->redirect(['reglist']);
            }else{
                echo 'false';
            }
        
    }



}
