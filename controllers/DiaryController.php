<?php

namespace app\controllers;

use app\models\DiaryTb;
use Yii;
use yii\data\ActiveDataProvider;
/*use yii\web\Request;
use yii\web\UrlManager;*/
use yii\helpers\Url;
use app\models\SendItem;
use app\models\GroupSave;
use app\models\Unit;
use app\models\UploadFile;
use app\models\FileUpload;
use app\models\ReciverReport;
use yii\db\Query;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class DiaryController extends \yii\web\Controller
{
   
	  public function init()
    {
         
    	$urlfix = ['diary%2Ftable' => 'pass'];

        $session = Yii::$app->session;
        $permitpass = $session['level'];
        if($permitpass == 'admin' || $permitpass == 'staff' || $permitpass == 'staffbkk'){
            return true;
            
        }else{
                $session->setFlash('warning',[
                'body'=>'พื้นที่เฉพาะเจ้าหน้าที่ กรุณา login',
                'options'=>['class'=>'alert-danger']
                ]);

	              	$sitelogin = Url::to(['/site/login']);
	               $urlto =  Url::to();
	               $baseurl =  Url::base()."/index.php?r=";
	               $cutstring = str_replace($baseurl,"",$urlto);
	           		$passport = false;
				   if(array_key_exists($cutstring, $urlfix )){ $passport = $urlfix[$cutstring]; }
					if($passport == 'pass'){ return true; }else{	return $this->redirect($sitelogin); }
          //return $this->redirect(Url::to());
         
        }

    }



    public function actionIndex()
    {
        return $this->render('index');
    }



	public function actionForm($datetoday=null)
	{

	    
			if(!$datetoday){
				$datetoday = date("Y-m-d");
			}
	    	
			$datenight = $datetoday." 23:59:59.999";
			$count= diarytb::find()->where(['between','diary_date',$datetoday,$datenight])->count();



			//------------------------
			 $session = Yii::$app->session;
			 $email = $session['email'];
			$modelsendems = senditem::find()->where(['and',['and',['status_item'=>'บันทึกรับ'],['or','id_reg_type=1','id_reg_type=3']],['between','date_send',$datetoday,$datenight]])->count();
			$modelsendreg = senditem::find()->where(['and',['and',['status_item'=>'บันทึกรับ'],['or','id_reg_type=2','id_reg_type=5']],['between','date_send',$datetoday,$datenight]])->count();
			
			$modelairmail = senditem::find()->where(['and',['and',['status_item'=>'บันทึกรับ'],'id_reg_type=6'],['between','date_send',$datetoday,$datenight]]);
			$modelsendair = $modelairmail->count();
			
			$modelsendman = senditem::find()->where(['and',['and',['status_item'=>'บันทึกรับ'],'id_reg_type=4'],['between','date_send',$datetoday,$datenight]]);
			$mansum = ($modelsendman->sum('qty_item')?$modelsendman->sum('qty_item'):0);
			//---------------//
			//$price_airmail = groupsave::find()->where(['and','type_doc="airmail"',['between','date_create',$datetoday,$datenight]]);
		
			$airsum = ($modelairmail->sum('price_item_post')?$modelairmail->sum('price_item_post'):0);
			$pricemansum = ($modelsendman->sum('price_item_post')?$modelsendman->sum('price_item_post'):0);;

	    if (Yii::$app->request->post()) {
	    		if($count){
	    			$model = diarytb::find()->where(['between','diary_date',$datetoday,$datenight])->one();
	    			$model->load(Yii::$app->request->post());
	    		}else{
		    		$model = new diarytb;
		        	$model->load(Yii::$app->request->post());	
	    		}
	            // form inputs are valid, do something here
	            if($model->save()){

	            	return $this->redirect(['table']);
	            }

	            
	       
	    }else{
			if($count){
			$model = diarytb::find()->where(['between','diary_date',$datetoday,$datenight])->one();
			return $this->render('_form', ['model' => $model,'ems'=>$modelsendems,'air'=>$modelsendair,'reg'=>$modelsendreg,'mansum'=>$mansum,'email'=>$email,'airsum'=>$airsum,'pricemansum'=>$pricemansum]);
			}else{
				$model = new diarytb;
				$model->diary_date = $datetoday;
				//จะต้องเรียก จำนวนของ การรับ พัสดุ ems การส่งems การส่ง ลงทะเบียน การส่งการบินไทย


				return $this->render('_form', ['model' => $model,'ems'=>$modelsendems,'air'=>$modelsendair,'reg'=>$modelsendreg,'mansum'=>$mansum,'email'=>$email,'airsum'=>$airsum,'pricemansum'=>$pricemansum]);
			}

	    }
	    	

		}
	




		public function actionTable()
		{	
			$model = diarytb::find()->orderBY(['diary_date'=>SORT_DESC])->limit(1000)->all();
			
			Yii::$app->params['customparam']='diarymsg';
			return $this->render('table',['model'=> $model]);
		}

		

		public function actionDelete($id)
		{
			$model = diarytb::findOne(['id_diary'=>$id]);
			 if($model->delete()){
                return $this->redirect(['table']);
            }else{
                echo 'false';
            }
		}

		public function actionDetail($id){
				$model = DiaryTb::find()->where(['id_diary'=>$id])->one();

			return $this->renderAjax('detail',['model'=>$model]);
		}

		public function actionReport($date = null){
			Yii::$app->params['customparam']='report';
			$date = ($date?$date:date('Y-m-d'));
			$model = unit::find()->where(['unit_in'=>1])->all();
			$array_report = reciverreport::find()->where(['date'=>$date])->all();
			$result = ArrayHelper::index($array_report, 'id_unit');

			$model_upload = new UploadFile;
			$model_file = FileUpload::find()->where(['tag_file'=>'report-'.$date])->one();
			return $this->render('report',['model'=>$model,'result'=>$result,'date'=>$date,'model_upload'=>$model_upload,'model_file'=>$model_file]);
		}

		public function actionReciverform($date = null){

			$date = ($date?$date:date('Y-m-d'));

			$model = unit::find()->where(['unit_in'=>1])->all();
			$array_report = reciverreport::find()->where(['date'=>$date])->all();
			$result = ArrayHelper::index($array_report, 'id_unit');
			return $this->render('reciverform',['model'=>$model,'date'=>$date,'result'=>$result]);
		}

		

		public function actionUpdatereciver(){
			if(Yii::$app->request->post('reciver_array')){
				$reciver_array = Yii::$app->request->post('reciver_array');
				$date = Yii::$app->request->post('date');
				foreach ($reciver_array as $key => $value) {
				          $id_unit = $reciver_array[$key]['id'];
				          //$qty_ems = $reciver_array[$key]['qty_ems'];
				          $qty_reg = $reciver_array[$key]['qty_reg'];
				          $qty_manmail = $reciver_array[$key]['qty_manmail'];
				          $comment  = $reciver_array[$key]['comment'];
				          $date  = $reciver_array[$key]['date'];

				           $model = reciverreport::find()->where(['and',['id_unit'=>$id_unit],['date'=>$date]])->one();
				           if($model == NULL){
				           			$model = new reciverreport;
						           

				           }
				           			//$model->qty_ems = $qty_ems;
						           $model->qty_reg = $qty_reg;
						           $model->qty_manmail = $qty_manmail;
						           $model->comment = $comment;
						           $model->date = $date;
						           $model->id_unit = $id_unit;
						           if($model->save()){
						          
						           }
				          }

				           return $this->redirect(['report','date'=>$date]);


				
		}

		}




		public function actionAircheck($date = null,$mode=null,$view=null){
			Yii::$app->params['customparam']='report';
			$date = ($date?$date:date('Y-m-d'));
			$mode =($mode?$mode:'airmailbkk');

			switch ($view) {
				case 'kk':
					$mode = 'airmail';
					break;
				case 'bkk':
					$mode = 'airmailbkk';
					break;
				
				
			}
		
			$groupmove = groupsave::find()->where(['and',['id_group'=>$mode.'-'.$date],['type_doc'=>$mode]])->one();
			$id_group = "";
			$number_book ="";
			if($groupmove != NULL){
			$id_group =$groupmove->id;
			$number_book = $groupmove->number_book;
			
			}
			$model = senditem::find()->where(['group_item_move'=>$id_group])->all();
			if($view == null){
			return $this->render('aircheck',['model'=>$model,'date'=>$date,'number_book'=>$number_book,'mode'=>$mode]);
			}else{
			return $this->render('airview',['model'=>$model,'date'=>$date,'number_book'=>$number_book,'view'=>$view]);	
			}

			
		}

		public function actionUpdatecheck(){
			$session = Yii::$app->session;
			$email = $session['email'];
			$mode;
			$date;
			if(Yii::$app->request->post('check_array')){
				$date = Yii::$app->request->post('date');
				$mode =	Yii::$app->request->post('mode');
				$check_array = Yii::$app->request->post('check_array');
				foreach ($check_array as $key => $value) {
					$id_item = $check_array[$key]['id_item'];
					$model = senditem::find()->where(['id_item'=>$id_item])->one();
					if($model != NULL){
						$model->status_item = "รับแล้ว";
						$str = $model->commit_item;
						$str_array = explode(',', $str);
						if(count($str_array) < 2){
						//$str_array.push $email;
						array_push($str_array,$email);
						}else{
						$str_array[1] = $email;
						}
						$model->commit_item = $str_array[0].",".$str_array[1];
						$model->update();
					}
				}
			}

			return $this->redirect(['aircheck','date'=>$date,'mode'=>$mode]);

		}


		 public function actionUpload($date)
		    {
		    	$date =($date?$date:date('Y-m-d'));
		        $model = new UploadFile();

		        if (Yii::$app->request->isPost) {
		            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

		            $model_file = FileUpload::find()->where(['tag_file'=>'report-'.$date])->one();
		            if(!count($model_file)){
		         	$model_file = new FileUpload;
		            }
		            if ($model->upload($date)) {
			            	$model_file->file_name = $date.'.'.$model->imageFile->extension;
			            	$model_file->status_file = 'test';
			            	$model_file->file_path ='uploadreport/'.$date.'.'.$model->imageFile->extension;
			            	$model_file->tag_file = 'report-'.$date;
			            	$model_file->comment = date('Y-m-d :H-i-s');
			            	if($model_file->save()){
			                return $this->redirect(['report','date'=>$date]);
			            	}
		           }else{

		           	return;
		           }


		            
		          
		        }

		        return $this->render('upload', ['model' => $model]);
		    }


}
