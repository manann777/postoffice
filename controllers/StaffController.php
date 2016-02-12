<?php

namespace app\controllers;
use app\models\StaffTb;
use app\models\SendItem;
use Yii;
use yii\web\Session;
use yii\base\Action;


class StaffController extends \yii\web\Controller
{

  

     public function init()
    {
         
        $session = Yii::$app->session;
        if($session['level'] == 'admin' || $session['level'] == 'staff'){
            return true;
            
        }else{
                $session->setFlash('warning',[
                'body'=>'พื้นที่เฉพาะเจ้าหน้าที่ กรุณา login',
                'options'=>['class'=>'alert-danger']
                ]);

           return $this->redirect(['/site/login']);
         
        }

    }


    public function actionIndex()
    {
        return $this->redirect(['stafflist']);
    }

    public function actionStafflist()
    {
    	$model = Stafftb::find()->all();
        return $this->render('stafflist',['model'=>$model]);
    }
    public function actionCreate()
    {
        $model = new stafftb;
        if(yii::$app->request->post()){
    		$model->load(Yii::$app->request->post());
    		if($model->save()){

                //$stafflist = stafftb::find()->all();
    		  return $this->redirect(['stafflist']);
            }
    	}

        return $this->render('create',['model'=>$model]);
    }
    public function actionUpdate($id)
    {
			$stafffind = stafftb::findOne($id);
        	if(yii::$app->request->post()){
            $stafffind->load(yii::$app->request->post());
            	if($stafffind->save()){
                return $this->redirect(['stafflist']);
            	}
        	}
        	return $this->render('update',['model'=> $stafffind]);

    }

    public function actionDelete($id)
    {
       
        $model = stafftb::findOne($id);
            if($model->delete()){
                return $this->redirect(['stafflist']);
            }else{
                echo 'false';
            }
        
    }
  
    /*public function actionLogin()
    {       if(yii::$app->request->post()){
            $post = yii::$app->request->post();
            $model = new stafftb;
            $email_validate = $model->getLevel($post['email']);
            //echo $email_validate->level_staff;
           // $date = new DateTime();
            
            $session = new Session;
            $session->open();
            $session['level'] = $email_validate->level_staff;
            $session['email'] = $post['email'];
            $session['name'] = $email_validate->name_staff;
           // $session['time_in'] = $date->getTimestamp();
           // $session_user = $session;
            $session->close();
            
            //echo $session_user->getId();
            print_r($session['level']);
        }else{
            return $this->render('login');
        }

        
    }*/



}
