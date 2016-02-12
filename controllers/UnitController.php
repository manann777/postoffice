<?php

namespace app\controllers;
use app\models\Unit;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\StaffTb;
use yii\web\Session;
use yii\helpers\Url;
use yii\helpers\Json;

class UnitController extends \yii\web\Controller
{



    public function init()
    {
        /*if (Yii::$app->user->isGuest) {
            throw new \yii\web\HttpException(511, Yii::t('yii', 'Network Authentication Required'));
        }*/
        $urlfix = ['unit%2Funitlistjson'=>'pass'];
        $session = Yii::$app->session;
        if($session['level'] == 'admin' || $session['level'] == 'staff'){
            return true;
            
        }else{
                 $sitelogin = Url::to(['/site/login']);
                 $urlto =  Url::to();
                 $baseurl =  Url::base()."/index.php?r=";
                 $cutstring = str_replace($baseurl,"",$urlto);
                $passport = false;
           if(array_key_exists($cutstring, $urlfix )){ $passport = $urlfix[$cutstring]; }
          if($passport == 'pass'){ 
            
            return true; }else{  

               $session->setFlash('warning',[
                'body'=>'พื้นที่เฉพาะเจ้าหน้าที่ กรุณา login',
                'options'=>['class'=>'alert-danger']
                ]);
            return $this->redirect($sitelogin); }
         
        }

    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUnitlist()
    {
        $model = Unit::find()->all();
        return $this->render('unitlist',['model'=>$model]);
    }

    public function actionCreate()
    {
        $model = new unit;
        if(yii::$app->request->post()){
    		$model->load(Yii::$app->request->post());
    		if($model->save()){

                $unitlist = unit::find()->all();
    		  return $this->redirect(['unitlist']);
            }
    	}

        return $this->render('create',['model'=>$model]);
    }

    public function actionAddunit($value){
            $model = new unit;
            $model->name_unit = $value;




            if($model->save()){
                $id = $model->id_unit;
                $items = ['id_unit'=>$model->id_unit,'name_unit'=>$model->name_unit];
                return Json::encode($items);
                
            }
    }

    public function actionUpdate($id)
    {
			$unitfind = unit::findOne($id);
        	if(yii::$app->request->post()){
                $post = yii::$app->request->post();
            $unitfind->load(yii::$app->request->post());
            
            	if($unitfind->save()){
               return $this->redirect(['unitlist']);
            	}
        	}
        	return $this->render('update',['model'=> $unitfind]);

    }

    public function actionDelete($id)
    {
       
        $model = unit::findOne($id);
            if($model->delete()){
                return $this->redirect(['unitlist']);
            }else{
                echo 'false';
            }
        
    }

    /*public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
    }*/
    public function actionUnitlistjson()
    {
        $modelUnit = Unit::find()->all();
        $listData=ArrayHelper::toArray($modelUnit);
        $jsonListdata = json_encode($listData);
        echo $jsonListdata;
    }

}
