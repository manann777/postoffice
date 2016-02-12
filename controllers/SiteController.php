<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Unit;
use app\models\ReciverReport;
use yii\helpers\ArrayHelper;
use mPDF;
use app\models\StaffTb;
use yii\web\Session;
use app\models\SendItem;
use app\models\FileUpload;



class SiteController extends Controller
{
   /* public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($date=null)
    {   
        Yii::$app->params['customparam']='indextop';
        
        $session = Yii::$app->session;
        $array_login = ['login'=>false,'email'=>'guess'];
        $array_login['login'] = ($session['id'] !=""? true : false);
        $array_login['email'] = ($session['email'] !=""?$session['email']:'guess');
        /*Yii::$app->view->params['userlogin'] = $array_login['login'];
        Yii::$app->view->params['useremail'] = $array_login['email'];*/

        $model = new senditem;
        $defaultsDate = date('Y-m-d 00:00:00');
        $defaulteDate = date('Y-m-d 23:59:00');
        $model = senditem::find()->where(['between','date_send',$defaultsDate,$defaulteDate])->all();


       /*-------*/
      
       $date = ($date?$date:date('Y-m-d'));
        $model_recive = unit::find()->where(['unit_in'=>1])->all();
        $array_report = reciverreport::find()->where(['date'=>$date])->all();
        $result = ArrayHelper::index($array_report, 'id_unit');
       /*-------*/

       $model_file = FileUpload::find()->where(['tag_file'=>'report-'.$date])->one();
        return $this->render('index',['array_login'=>$array_login,'model'=>$model,'model_recive'=>$model_recive,'result'=>$result,'date'=>$date,'model_file'=>$model_file]);
    }

   /* public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }*/

    /*public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }*/

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()

    {    Yii::$app->params['customparam']='about';
        return $this->render('about');
    }


    //custom action
     public function actionTools()
    {
        return $this->render('tools');
    }

      public function actionYoutube()
    {
        return $this->render('youtube');
    }
   public function actionCreatempdf(){
        $mpdf=new mPDF('th');

        $mpdf->WriteHTML($this->renderPartial('mpdf'));
        $mpdf->Output();
        exit;
        //return $this->renderPartial('mpdf');
    }
    public function actionSamplepdf() {
        $mpdf = new mPDF;
        $mpdf->WriteHTML('Sample Text');
        $mpdf->Output();
        exit;
    }
    public function actionForcedownloadpdf(){
        $mpdf=new mPDF('th');
        $test = "<b>สวัสดี วันนี้ วัน จันทร์</b>";
        $number = 5 ;
        $mpdf->WriteHTML($this->renderPartial('mpdf',['test'=>$test,'number'=>$number]));
        $mpdf->Output('MyPDF.pdf', 'D');
        exit;
    }

    public function actionLogin()
    {       $session = new Session;
            $session->open();
            $path = Yii::getAlias("../../simplesaml/lib/_autoload.php");
            require_once($path);
            $as = new \SimpleSAML_Auth_Simple('default-sp');
            $as->requireAuth();
            $attributes = $as->getAttributes();
            $session['id'] = $attributes['SSO_USER_ID'][0];
            $session['Username'] = $attributes['SSO_USERNAME'][0];
            $session['Firstname'] = $attributes['SSO_FIRSTNAME'][0];
            $session['Lastname'] = $attributes['SSO_LASTNAME'][0];
            $session['citizenId'] = $attributes['SSO_CITIZEN_ID'][0];
            $session['email'] = $attributes['SSO_MAIL'][0];
            $session['fullname'] =$attributes['SSO_FULLNAME'][0];
            $model = new stafftb;
            $email_validate = $model->getLevel($session['email']);
            if($email_validate != null){
            $session['level'] = $email_validate->level_staff;
            $session['unit'] = $email_validate->unit;
            $session->close();
            return $this->redirect(['/site']);
            }else{
            return $this->redirect(['site/newuser']);    
            }

    }

    public function actionNewuser(){
        $session = new Session;
        $session->open();
        $model = new stafftb;
        $model->email_staff = $session['email'];
        $model->name_staff = $session['fullname'];
        if(yii::$app->request->post()){
         $model->load(Yii::$app->request->post());
         $model->level_staff = 'user';
         $session['level'] = $model->level_staff;
         $session['unit'] = $model->unit;
         if($model->save()){
            return $this->redirect(['/site']);
         }
        }
        return $this->render('newuser',['model'=>$model]);
    }
    public function actionLogin_old()
    {      
        /*Yii::$app->view->params['userlogin'] = false;
        Yii::$app->view->params['useremail'] = 'GUESS';*/
        if(yii::$app->request->post()){
            $post = yii::$app->request->post();
           
            
          
            $model = new stafftb;
            $email_validate = $model->getLevel($post['email']);
            //echo $email_validate->level_staff;
           // $date = new DateTime();
            if($email_validate != null){
            $session = new Session;
            $session->open();
            $session['level'] = $email_validate->level_staff;
            $session['email'] = $post['email'];
            $session['name'] = $email_validate->name_staff;
            $session['id'] = $session->getId();
           // $session['time_in'] = $date->getTimestamp();
           // $session_user = $session;
            $session->close();
            
            //echo $session_user->getId();
           // print_r($session['level']);
             return $this->redirect(['/site']);
         }else{ 

            Yii::$app->getSession()->setFlash('warning',[
                'body'=>'การบันทึกผิดพลาด..',
                'options'=>['class'=>'alert-danger']
                ]);
            return $this->render('login'); }
        }else{
            return $this->render('login');
        }

        
    }

    public function actionLogout(){
       // $session = Yii::$app->session;
        //$session['id'] = "";
        $session = new Session;
            $session->open();
            $path = Yii::getAlias("../../simplesaml/lib/_autoload.php");
            require_once($path);
            $as = new \SimpleSAML_Auth_Simple('default-sp');
            if ($as->isAuthenticated()) {
                $as->logout();
            }

        $session->destroy();
       
        return $this->redirect(['/site']);
    }

   
}
