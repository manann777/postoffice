<?php

namespace app\controllers;
use app\models\SendItem;
use app\models\Unit;
use app\models\GroupSave;
use app\models\DiaryTb;
use yii\helpers\ArrayHelper;
use yii;
use yii\db\Query;
use yii\data\Sort;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\StaffTb;
use yii\web\Session;
use yii\helpers\Url;
use yii\data\SqlDataProvider;
use yii\helpers\Json;


class StafftoolsController extends \yii\web\Controller
{
   


  public function init()
    {   

        $urlfix = ['stafftools%2Freport' => 'pass'];

        $session = Yii::$app->session;

        $permitpass = $session['level'];
        if($permitpass == 'admin' || $permitpass == 'staff' || $permitpass == 'staffbkk'){
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
          //return $this->redirect(Url::to());
         
        }

    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCompress()
    {
        $postval = yii::$app->request->post();
        $minarray = min($postval['listitembox']);
       // $model = senditem::find()->where(['id_item' => $postval['listitembox']])->all();
        //เมื่อเกิดกลุ่มใหม่ จะทำการสร้างกลุ่มใหม่ โดยใช้ email ของ แอดมินควบคุม
        $groupmodel = groupsave::findOne(['id_group'=>$minarray]);
        if($groupmodel == NULL){
          $groupmodel = new groupsave;
          $groupmodel->id_group = $minarray;
        }
          $groupmodel->type_doc = 'ยังไม่ได้จัดประเภท';
          $groupmodel->number_book = 'ยังไม่มีหมายเลข';
          $groupmodel->date_update = date('Y-m-d');
          $groupmodel->status_group = 'certificated';
          $groupmodel->price_system = 0;
          $groupmodel->price_postoffice =0;
          $groupmodel->filepath = NULL;
          $groupmodel->comment ="";
          $groupmodel->email_owner ="admin@email.com";
         if($groupmodel->save()){

         } 


        if(sizeof($postval['listitembox']) != 0){
          
            if(senditem::updateAll(['group_item'=>$minarray],['id_item'=>$postval['listitembox']])){
              return  $this->redirect(['listitem','groupmodel'=>$minarray]);
            }
        }
        
    }

    public function actionDeletecheck()
    {
        $postval = yii::$app->request->post();
        if(senditem::deleteAll(['id_item'=>$postval['listitembox']])){
            return  $this->redirect(['listitem']);
        }
    }

    public function actionManage($groupmodel)
    {   
          $model = senditem::find()->where(['group_item' => $groupmodel])->orderBy(['id_item'=> SORT_ASC])->all();
        return $this->render('manage',['model'=>$model]);
    }

      public function actionListitem($groupmodel = null,$date = null)
    {
         $sort = new Sort([
        'defaultOrder'=>['id_item'=>SORT_DESC],
        'attributes' => [
            'id_item'=>[
                'label' => '<i class="fa fa-sort"></i> เรียงเลขพัสดุ',
                'default' => SORT_DESC,
            ],
            'group_item' => [
                'asc' => ['group_item' => SORT_ASC,'id_item'=>SORT_ASC],
                'desc' => ['group_item' => SORT_DESC,'id_item'=>SORT_ASC],
                'default' => SORT_DESC,
                'label' => '<i class="fa fa-sort"></i> เรียงกลุ่มพัสดุ',
            ],
            'status_item' => [
            	'asc'=>['status_item'=>SORT_ASC ,'group_item' => SORT_ASC,'id_item'=>SORT_ASC],
            	'desc'=>['status_item'=>SORT_DESC ,'group_item' => SORT_ASC,'id_item'=>SORT_ASC],
            	'default' => SORT_DESC,
            	'label' => '<i class="fa fa-sort"></i> เรียงสถานะ',
            ],
        ],
        ]);
        if(!$date){
             $date = date('Y-m-d');
        } 
        /*$sevendayback = date_create($date);
        $sevendayback = date_modify($sevendayback,'-7 day');
        $curs = date_format($sevendayback,'Y-m-d');*/
        $curs = $date;
        $curf = $date." 23:59:59.999";
        
       if(!$groupmodel){
        $model =  senditem::find()->where(['and',['between', 'date_send', $curs, $curf],['not', ['status_item' => 'ลงทะเบียนฝากส่ง']]])->orderBy($sort->orders)->all();
        $modelgroupsave = new groupsave;
       
       }else{
       $model = senditem::find()->where(['and',['group_item' => $groupmodel],['not', ['status_item' => 'ลงทะเบียนฝากส่ง']]])->orderBy($sort->orders)->all();
       
       $modelgroupsave = groupsave::findOne(['id_group'=>$groupmodel]);
       if(!$modelgroupsave){
        $modelgroupsave = new groupsave;
       }

       }	
       	  Yii::$app->params['customparam']='stafflist';
               return $this->render('listitem',['model'=>$model,'sort'=>$sort,'group'=>$groupmodel,'modelgroupsave'=>$modelgroupsave,'date'=>$date]);
        
        
    }



    public function actionGroupsave($date = null)
    {   
        //SELECT COUNT(*) AS counter ,send_item.group_item FROM send_item WHERE send_item.group_item IN( SELECT group_save.id_group FROM group_save ) group by send_item.group_item 
      //SELECT COUNT(*) AS counter ,group_save.id_group FROM send_item INNER JOIN group_save ON send_item.group_item = group_save.id_group group by send_item.group_item 
      $sort = new Sort([
        'defaultOrder'=>['id_group'=>SORT_DESC],
        'attributes' => [
            'id_group'=>[
                'label' => '<i class="fa fa-sort"></i> เรียงเลขกลุ่ม',
                'default' => SORT_DESC,
                        ],
              'type_doc'=>[
                'label' => '<i class="fa fa-sort"></i> เรียงประเภท',
                'default' => SORT_DESC,
              ],
              'number_book'=>[
                'label' => '<i class="fa fa-sort"></i> เรียงเล่ม',
                'default' => SORT_DESC,
              ],
            ],
        ]);


                $query = new Query;
                $query->select([
                    'COUNT(*) AS counter', 
                    'group_save.id_group AS id_group'])  
                  ->from('send_item')
                  ->join('INNER JOIN', 'group_save',
                        'send_item.group_item = group_save.id_group')    
                  ->groupBy(['send_item.group_item']);
              $count = $query->all();
               // $command = $query->createCommand();
               // $data = $command->queryAll(); 
              //print_r($count);
              //$result = ArrayHelper::map($count, 'id_group', 'counter');
              $result = ArrayHelper::index($count, 'id_group');
             // print_r($result);

      if(!$date){
        $model = groupsave::find()->orderBy($sort->orders)->all();
        }else{
        /*$sevendayback = date_create($date);
        $sevendayback = date_modify($sevendayback,'-7 day');
        $curs = date_format($sevendayback,'Y-m-d');*/
        $curs = $date;
        $curf = $date." 23:59:59.999";
        $model = groupsave::find()->where(['between','date_update', $curs, $curf])->orderBy($sort->orders)->all();
        }

        $activeprovider = new ActiveDataProvider([
        'query'=> groupsave::find(),
         'pagination'=>['pageSize'=>20],
        ]);
       
        Yii::$app->params['customparam'] = 'user';


        return $this->render('groupsave',['model'=>$model,'sort'=>$sort,'dataProvider'=>$activeprovider,'counter'=>$result]);
    }



    public function actionUpload($id)
    { 
      $model = groupsave::findOne(['id'=>$id]);
      $model_item = senditem::find()->where(['group_item_move'=>$id])->orderBy('id_item','group_item_move')->all();
    
      $datecreate =  $model->date_create;
      $post =Yii::$app->request->post();
      $date = $model->date_create;
     if (Yii::$app->request->post() && isset($post['post_price'])) {
   
              foreach($post['post_price'] as $key => $value){
                  $model_postprice = senditem::find()->where(['id_item'=>$key])->one();
                  $model_postprice->price_item_post = $value;
                  $model_postprice->save();
              }

              if(isset($post['post_man_price'])){

                  foreach($post['post_man_price'] as $key => $value){
                  $model_postprice = senditem::find()->where(['id_item'=>$key])->one();
                  $model_postprice->price_item_post = $value;
                  $model_postprice->save();
              }

              }


      }
      if (Yii::$app->request->post()){

              if($post['comment']){
              $model->comment = $post['comment'];
              }
            


               if($model->imageFile = UploadedFile::getInstanceByName('imageFile')){
               $model->imageFile = UploadedFile::getInstanceByName('imageFile');
               $model->filepath = 'uploads/group'.$id.'.'.$model->imageFile->extension;
              $model->imageFile->saveAs('uploads/group'.$id.'.'.$model->imageFile->extension,false);
               }
            if($model->save()){
                   return  $this->redirect(['worktoday','date'=>$date]);
              } 
              else{

            Yii::$app->getSession()->setFlash('alertx',[
                'body'=>'ระบบไม่สามารถบันทึกข้อมูลบางประการได้ เช่น ข้อมูลราคา จะต้องเป็นตัวเลข หรือ ไฟล์ที่อัพโหลด จะต้องเป็นไฟล์ PDF เท่านั้น',
                'options'=>['class'=>'alert-danger']
              ]);
             return  $this->redirect(['worktoday','date'=>$date]);
           } 
        
       
           // return  $this->redirect(['worktoday','date'=>$date]);
     }

 
        

      return $this->renderAjax('upload',['model'=>$model,'model_item'=>$model_item]);
    }



  public function actionUnsetgroup($groupmodel)
    { 
      if(senditem::updateAll(['status_item'=>'รับรองเอกสาร'],['group_item'=>$groupmodel,'status_item'=>'บันทึกรับ'])){

          $model = groupsave::findOne(['id_group'=>$groupmodel]); 
          $model->type_doc = 'ยังไม่ได้จัดประเภท';
          $model->number_book = 'ยังไม่มีหมายเลข';
          $model->date_update = date('Y-m-d');
          $model->status_group = 'certificated';
          $model->price_system = 0;
          $model->price_postoffice =0;
          $model->filepath = NULL;
          $model->comment ="";
           if($model->save()){
             return $this->redirect(['listitem','groupmodel'=>$groupmodel]);

           }
      }
    }

    


    public function actionDeletegroup($id){
        $modelitem = senditem::deleteAll('group_item='.$id);
        
        $modelgroupsave = groupsave::find()->where(['id_group'=>$id])->one();
        $modelgroupsave->delete();
      


      return  $this->redirect(['groupsave']);
    }

    public function actionWorktoday($date = null){
        Yii::$app->params['customparam']='worktoday';
      $date = ($date?$date:date('Y-m-d'));
      $curs = $date;
      $curf = $date." 23:59:59.999";
      //$model = groupsave::find()->where(['between','date_create', $curs, $curf])->all();
       $session = Yii::$app->session;
       $str = 'airmail-'.$date;
      if(!groupsave::find()->where(['id_group'=>$str])->one()){

        Yii::$app->db->createCommand()
      ->batchInsert('group_save', ['id_group', 'type_doc','number_book','date_create','date_update','price_system','price_postoffice','status_group','email_owner','comment'], 
      [
        ['airmail-'.$date,'airmail','ยังไม่มีหมายเลข',$date,$date,0,0,'certificated',$session['email'],''],
        ['lastdoc-'.$date,'lastdoc','ยังไม่มีหมายเลข',$date,$date,0,0,'certificated',$session['email'],''],
        ['reglast-'.$date,'reglast','ยังไม่มีหมายเลข',$date,$date,0,0,'certificated',$session['email'],''],
        
      ])
      ->execute();
      }

      $model = groupsave::find()->where(['and',['between','date_create', $curs, $curf],['not in','type_doc','airmailbkk']])->all();

      $query = new Query;
                $query->select([
                    'COUNT(*) AS counter', 
                    'group_save.id_group AS id_group',
                    'group_save.id AS id'])  
                  ->from('send_item')
                  ->where('date_send  between "'.$curs.'" and "'.$curf.'"')
                  ->join('INNER JOIN', 'group_save',
                        'send_item.group_item_move = group_save.id')    
                  ->groupBy(['send_item.group_item_move']);
              $count = $query->all();
        $result = ArrayHelper::index($count, 'id');
      //print_r($result);

        $query = new Query;
                $query->select([
                    'SUM(price_item_post) AS sumter', 
                    'send_item.group_item AS id'])  
                  ->from('send_item')
                  ->where('date_send  between "'.$curs.'" and "'.$curf.'"')  
                  ->groupBy(['send_item.group_item']);
              $sumquery = $query->all();
        $resultsum = ArrayHelper::index($sumquery, 'id');


          $countdiary = diarytb::find()->where(['between','diary_date',$curs,$curf])->count();
      
      if(!$countdiary){
       
        

      $session = Yii::$app->session;
      $email = $session['email'];
      $modelsendems = senditem::find()->where(['and',['or','id_reg_type=1','id_reg_type=3'],['between','date_send',$curs,$curf]])->count();
      $modelsendreg = senditem::find()->where(['and',['or','id_reg_type=2','id_reg_type=5'],['between','date_send',$curs,$curf]])->count();
      $modelsendair = senditem::find()->where(['and','id_reg_type=6',['between','date_send',$curs,$curf]])->count();
      
      $modelsendman = senditem::find()->where(['and','id_reg_type=4',['between','date_send',$curs,$curf]]);
      $mansum = ($modelsendman->sum('qty_item')?$modelsendman->sum('qty_item'):0);
      
      $price_airmail = groupsave::find()->where(['and','type_doc="airmail"',['between','date_create',$curs,$curf]]);
      
      $airsum = ($price_airmail->sum('price_postoffice')?$price_airmail->sum('price_postoffice'):0);
       // 'receive_airmail', 'send_airmail', 'receive_mailreg', 'receive_mail', 'send_mail', 'sendback_post', 'return_post','send_ems','receive_ems','send_mailreg','price_airmail'

        $modeldiary = new diarytb;
        $modeldiary->diary_date = $curs;
        $modeldiary->receive_airmail = 0;
        $modeldiary->send_airmail = $modelsendair;
        $modeldiary->receive_mailreg= 0;
        $modeldiary->receive_mail=0;
        $modeldiary->send_mail=$mansum;
        $modeldiary->sendback_post = 0;
        $modeldiary->return_post = 0;
        $modeldiary->send_ems = $modelsendems;
        $modeldiary->receive_ems = 0;
        $modeldiary->send_mailreg =$modelsendreg;
        $modeldiary->price_airmail = $airsum;
        $modeldiary->mail_price = 0;
        $modeldiary->save();
      }

      return $this->render('worktoday',['model'=>$model,'result'=>$result,'date'=>$date,'resultsum'=>$resultsum]);
    }

    public function actionDetailgroup($id,$date,$type=null){
      $session = Yii::$app->session;
      $date = ($date?$date:date('Y-m-d'));
      $curs = $date;
      $curf = $date." 23:59:59.999";
      $str = 'airmail-'.$date;
      $laststr = 'lastdoc-'.$date;
      $reglast = 'reglast-'.$date;
      $find_id_airmail = groupsave::find()->where(['id_group'=>$str])->one();
      $find_id_lastdoc = groupsave::find()->where(['id_group'=>$laststr])->one();
      $find_id_reglast = groupsave::find()->where(['id_group'=>$reglast])->one();
      
       
      
      //หาจดหมายการบินไทย แล้วย้าย
        $modelair = new senditem;
        $air_id = $find_id_airmail->id;
        if($modelair::updateAll(['group_item_move' => $air_id],['id_reg_type'=>6,'group_item'=>$id])){
          $find_id_airmail->status_group = 'certificated';
          $find_id_airmail->save();
        }

      //หาจดหมายธรรมดา แล้วย้ายไป lastdoc
        $modelmanmail = new senditem;
        $last_id = $find_id_lastdoc->id;
        if($modelmanmail::updateAll(['group_item_move' => $last_id],['id_reg_type'=>4,'group_item'=>$id])){

          $find_id_lastdoc->status_group = 'certificated';
          $find_id_lastdoc->save();
        }
      
     //คำนวน EMS น้อยกว่า 5ส่งไป lastdoc
        $modelems = senditem::find()->where(['and',['or',['id_reg_type'=>1],['id_reg_type'=>3]],['group_item'=>$id]])->all();
       // echo count($modelems);
        if(count($modelems) < 5){
          $modeltolast = new senditem;
          if($modeltolast::updateAll(['group_item_move' => $last_id],['and',['or',['id_reg_type'=>1],['id_reg_type'=>3]],['group_item'=>$id]])){
          $find_id_lastdoc->status_group = 'certificated';
          $find_id_lastdoc->save();
          }
          }

      //คำนวน regmail น้อยกว่า 5 ส่งไป reglast
          $last_reg = $find_id_reglast->id;
          $modelreg = senditem::find()->where(['and',['or',['id_reg_type'=>2],['id_reg_type'=>5]],['group_item'=>$id]])->all();
       // echo count($modelems);
        if(count($modelreg) < 5){
          $modeltolast = new senditem;
            if($modeltolast::updateAll(['group_item_move' => $last_reg],['and',['or',['id_reg_type'=>2],['id_reg_type'=>5]],['group_item'=>$id]])){
          $find_id_reglast->status_group = 'certificated';
          $find_id_reglast->save(); }
          }

      
      $airmail_model = senditem::find()->where(['and',['group_item_move'=>$air_id],['group_item'=>$id]])->all();
      $emsmail_model = senditem::find()->where(['and',['group_item_move'=>$id],['or',['id_reg_type'=>1],['id_reg_type'=>3]]])->all();
      $regmail_model = senditem::find()->where(['and',['group_item_move'=>$id],['or',['id_reg_type'=>2],['id_reg_type'=>5]]])->all();

      $lastmail_model = senditem::find()->where(['and',['group_item_move'=>$last_id],['group_item'=>$id]])->all();
      $lastreg_model = senditem::find()->where(['and',['group_item_move'=>$last_reg],['group_item'=>$id]])->all();
      $item_model = senditem::find()->where(['and',['group_item_move'=>$id],['id_reg_type'=>7]])->all();

      $itemstr = 'item-'.$date; 
      //$id_item_group;
      $find_id_item =  groupsave::find()->where(['id_group'=>$itemstr])->one();
      $id_item_group;
      if(count($item_model) > 0){
        
          if(!groupsave::find()->where(['id_group'=>$itemstr])->one()){
            $create_item_model = new groupsave;
            $create_item_model->id_group = $itemstr;
            $create_item_model->type_doc = 'itemdoc';
            $create_item_model->number_book = 'ยังไม่มีหมายเลข';
            $create_item_model->date_create = $date;
            $create_item_model->date_update = date('Y-m-d');
            $create_item_model->price_system = 0;
            $create_item_model->price_postoffice = 0;
            $create_item_model->status_group = 'certificated';
            $create_item_model->email_owner = $session['email'];
            $create_item_model->comment = '';
            if($create_item_model->save()){
              $id_item_group = $create_item_model->id;
              $model_item = new senditem;
              $model_item::updateAll(['group_item_move' => $id_item_group],['and',['id_reg_type'=>7],['group_item'=>$id]]);

            }
          }else{
              $find_id_item =  groupsave::find()->where(['id_group'=>$itemstr])->one();
              $id_item_group = $find_id_item->id;
              $model_item = new senditem;
              $model_item::updateAll(['group_item_move' => $id_item_group],['and',['id_reg_type'=>7],['group_item'=>$id]]);


          }

          $item_model = senditem::find()->where(['and',['group_item_move'=>$id_item_group],['group_item'=>$id]])->all();


      } 

      
       // $item_model = senditem::find()->where(['and',['group_item_move'=>$id],['id_reg_type'=>7]])->all();
      $model = senditem::find()->where(['group_item'=>$id])->all();
      $modelgroupsave = groupsave::find()->where(['id'=>$id])->one();
      if(count($emsmail_model)){
     
      $modelgroupsave->type_doc = "ems";
      $modelgroupsave->save();
      }else if(count($regmail_model)){
      
      $modelgroupsave->type_doc = "ลงทะเบียน";
      $modelgroupsave->save();
      }

      


      return $this->render('detailgroup',['model'=>$model,'air_model'=>$airmail_model,'last_model'=>$lastmail_model,'ems_model'=>$emsmail_model,'reg_model'=>$regmail_model,'lastreg_model'=>$lastreg_model,'item_model'=>$item_model,'group'=>$id,'groupsave'=>$modelgroupsave,'date'=>$date]);

    }




    public function actionSpgroup($id,$date=null){

      $model = senditem::find()->where(['group_item_move'=>$id])->orderBy('id_item','id_reg_type')->all();
      $modelgroupsave = groupsave::find()->where(['id'=>$id])->one();
      return $this->render('spgroup',['model'=>$model,'group'=>$id,'modelgroupsave'=>$modelgroupsave,'date'=>$date]);

    }

     public function actionSetcode($id,$type){
      if($type == 'ems' || $type == 'regmail'){
         $model = senditem::find()->where(['and',['group_item_move'=>$id],['in','id_reg_type',[1,2,3,5,6]]])->orderBy('id_item')->all();
      }else{
      $model = senditem::find()->where(['and',['group_item_move'=>$id],['in','id_reg_type',[1,2,3,5,6]]])->orderBy('id_item','id_reg_type')->all();
    }
      return $this->renderAjax('setcode',['id'=>$id,'model'=>$model,'type'=>$type]);
     }

     public function actionSubmitcode(){
      if(Yii::$app->request->post('checkbox110')){

        $checkbox110 = Yii::$app->request->post('checkbox110');
        //print_r($checkbox110);

        foreach ($checkbox110 as $key => $value) {
          $id = $checkbox110[$key]['id'];
          $id_reg = $checkbox110[$key]['id_reg'];
          $weight = $checkbox110[$key]['weight'];
          $price  = $checkbox110[$key]['price'];

         Yii::$app->db->createCommand()->update('send_item', ['id_reg_item' => $id_reg,'weight_item'=>$weight,'price_item'=>$price,'staff_do'=>true], ['id_item' => $id])->execute();
        }
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $data = ['success'=>true];
          return $data;
          
      }
      

     }

      public function actionApprove_none_item($id){

        if($id){
          $session = Yii::$app->session;
          $model = groupsave::find()->where(['id'=>$id])->one();
          $model->status_group = 'accepted';
          $model->email_owner = $session['email'];
          $model->save(); 

          $date = $model->date_create;
           return $this->redirect(['worktoday','date'=>$date]);
        }

       
      }


      public function actionUpdateitem($id)
    {
        


        $model = senditem::findOne($id);
        
        if(yii::$app->request->post()){
            
            $model->load(yii::$app->request->post());
            $model->last_update = date('Y-m-d H:i:s');

            if($model->save()){
              $groupid = $model->group_item_move;
              $modelgroup = groupsave::find()->where(['id'=>$groupid])->one();
              $type_doc = $modelgroup->type_doc;
              $date = $modelgroup->date_create;
         return $this->redirect(['spgroup','id'=>$groupid,'date'=>$date]);
            }
        }
        $check_item_off = [0,0];
        return $this->render('update',['model'=>$model,'setoff'=>$check_item_off]);

    }

   /* public function actionDeleteitem($id)
    {
        $model = senditem::findOne($id);
        $group_item = $model->group_item;
        if($model->delete()){
           // return $this->redirect(['senditemlist','groupmodel'=>$group_item]);
        }else{
            echo 'false';
        }
    }*/

     public function actionDeleteitem($id,$stage,$date)
    {
        $model = senditem::findOne($id);
        $group_item = $model->group_item;
        if($model->delete()){
            $stage = 'stafftools/'.$stage;
            return $this->redirect([$stage,'id'=>$group_item,'date'=>$date]);
        }else{
            echo 'false';
        }
    }

    

   public function actionMovedate($id){

    $model = groupsave::find()->where(['id'=>$id])->one();
    $old_date = $model->date_create;
    if(yii::$app->request->post()){
       $poster = yii::$app->request->post();
       $model->date_create = $poster['date_create'];
       $model->status_group = 'certificated';
       $datecreate = $poster['date_create'];
      // $modelsenditem = senditem::find()->where(['group_item'=>$id])->all();
       senditem::updateAll(['date_send'=>$datecreate,'group_item_move'=>$id,'status_item'=>'รับรองเอกสาร','last_update'=>date('Y-m-d H:i:s')],'group_item='.$id);

       if($model->save()){
        return $this->redirect(['stafftools/worktoday','date'=>$old_date]);
       }
        
      
    }else{
    return $this->renderAjax('movedate',['model'=>$model]);
  }
   }

   public function actionReportstaff(){
    Yii::$app->params['customparam']='report';
      $model = new groupsave;
     $defaultsDate = date('Y-m-01 00:00:00');
      $defaulteDate = date('Y-m-t 23:59:00');
      if(Yii::$app->request->getIsPost()){

         $unit = (Yii::$app->request->post('unit') != ''? Yii::$app->request->post('unit'):''); 
        // $id_reg = (Yii::$app->request->post('reg') !=''?Yii::$app->request->post('reg'):'%%'); 

        $scope_date_min = (Yii::$app->request->post('check_date_start') != ''? Yii::$app->request->post('check_date_start').' 00:00:00':$defaultsDate);
        $scope_date_max = (Yii::$app->request->post('check_date_end') != ''? Yii::$app->request->post('check_date_end').' 23:59:00':$defaulteDate );

        //print_r(Yii::$app->request->post());
        
         if($unit != ''){
          $model = groupsave::find()->where(['and',['and',['group_owner'=>$unit],['status_group'=>'accepted']],['and',['not in','type_doc',['airmail','lastdoc','reglast']],['between','date_create',$scope_date_min,$scope_date_max]]])->all();
            
         }else{
           
            $model = groupsave::find()->where(['and',['status_group'=>'accepted'],['and',['not in','type_doc',['airmail','lastdoc','reglast']],['between','date_create',$scope_date_min,$scope_date_max]]])->all();
    
         }
        
        $defaultsDate = $scope_date_min;
        $defaulteDate = $scope_date_max;

       //$model = groupsave::find()->where(['and',['between','date_create',$scope_date_min,$scope_date_max],['and',['like','id_reg_type',$id_reg,false],['like','id_unit_sender',$unit,false]] ])->all();
    

      }else{
        $model = groupsave::find()->where(['and',['status_group'=>'accepted'],['and',['not in','type_doc',['airmail','lastdoc','reglast']],['between','date_create',$defaultsDate,$defaulteDate]]])->all();
       
      }


      $query = new Query;
                $query->select([
                    'SUM(price_item_post) AS sumter', 
                    'send_item.group_item AS id'])  
                  ->from('send_item')
                  ->where('date_send  between "'.$defaultsDate.'" and "'.$defaulteDate.'"')  
                  ->groupBy(['send_item.group_item']);
              $sumquery = $query->all();
        $resultsum = ArrayHelper::index($sumquery, 'id');

                     /*
                      $countmoney = [];
                      $count =[];
                        foreach ($model as $key => $row) {
                          $item =  $row->type_doc;
                            if(array_key_exists($item,$countmoney)){
                             
                              if($item != 'lastdoc'){
                                $countmoney[$item][0] = $countmoney[$item][0]+$row->price_postoffice; 
                              }else{
                                $diarymodel = diarytb::find()->where(['diary_date'=>$row->date_create])->one();
                                $countmoney[$item][0] = $countmoney[$item][0]+$row->price_postoffice+$diarymodel->mail_price;
                                $model[$key]['price_postoffice'] = $row->price_postoffice+$diarymodel->mail_price;
                              }
                             
                             
                             $countmoney[$item][1] = $countmoney[$item][1] + 1;
                            }else{
                               //$countmoney[$item][0] = $row->price_postoffice;

                              if($item != 'lastdoc'){
                                $countmoney[$item][0] = $row->price_postoffice; 
                              }else{
                                $diarymodel = diarytb::find()->where(['diary_date'=>$row->date_create])->one();
                                $countmoney[$item][0] = $row->price_postoffice+$diarymodel->mail_price;
                                $model[$key]['price_postoffice'] = $row->price_postoffice+$diarymodel->mail_price;
                              }

                                $countmoney[$item][1] = 1;
                            }
                        }

                        foreach ($model as $key => $value) {
                         $email = $value->email_owner;
                         if(array_key_exists($email, $count)){
                          $count[$email] = $count[$email]+1;
                         }else{
                          $count[$email] = 1;
                         }
                        }
                    */
        // return $this->render('reportstaff',['model'=>$model,'countmoney'=>$countmoney,'count'=>$count]);
         return $this->render('reportstaff',['model'=>$model,'resultsum'=>$resultsum]);
   }
    

    public function actionReport(){
       Yii::$app->params['customparam']='report';
     $model = new senditem;
     $defaultsDate = date('Y-m-01 00:00:00');
      $defaulteDate = date('Y-m-t 23:59:00');
     if(Yii::$app->request->getIsPost()){

       

         $unit = (Yii::$app->request->post('unit') != ''? Yii::$app->request->post('unit'):'%%'); 
        $id_reg = (Yii::$app->request->post('reg') !=''?Yii::$app->request->post('reg'):'');
         $reg = ['in','id_reg_type',[1,2,3,4,5,6,8]];
        switch ($id_reg) {
          case '1':
            $reg = ['in','id_reg_type',[1,3]];
            break;
          
             case '2':
            $reg = ['in','id_reg_type',[2,5]];
            break;
            case '4':
            $reg = ['in','id_reg_type',[4]];
            break;
            case '6':
            $reg = ['in','id_reg_type',[6]];
            break;
            case '8':
            $reg = ['in','id_reg_type',[8]];
            break;

          default:
            $reg = ['in','id_reg_type',[1,2,3,4,5,6,8]];
            break;
        }


        // $reg =['like','id_reg_type',$id_reg,false];
        


        $scope_date_min = (Yii::$app->request->post('check_date_start') != ''? Yii::$app->request->post('check_date_start').' 00:00:00':$defaultsDate);
        $scope_date_max = (Yii::$app->request->post('check_date_end') != ''? Yii::$app->request->post('check_date_end').' 23:59:00':$defaulteDate );

        $model = senditem::find()->where(['and',['between','date_send',$scope_date_min,$scope_date_max],['and',$reg,['like','id_unit_sender',$unit,false]] ])->all();
      
       
      }else{
        $model = senditem::find()->where(['between','date_send',$defaultsDate,$defaulteDate])->all();
        
        
      }
     
      $count=[];
     foreach ($model as $key => $value) {
         $regname = $value->idRegType->type_reg;
         if(array_key_exists($regname, $count)){
          $count[$regname] = $count[$regname]+1;
         }else{
          $count[$regname] = 1;
         }
      }
     return $this->render('report',['model'=>$model,'count'=>$count]);
      
    }

    public function actionGetitem($date=null){
      Yii::$app->params['customparam']='getitem';
      $session = Yii::$app->session;
        $commit_item = $session['email'];

        $sort = new Sort([
        'defaultOrder'=>['id_item'=>SORT_DESC],
        'attributes' => [
            'id_item'=>[
                'label' => '<i class="fa fa-sort"></i>เรียงเลขพัสดุ',
                'default' => SORT_DESC,
            ],
            'group_item' => [
                'asc' => ['group_item' => SORT_ASC,'id_item'=>SORT_ASC],
                'desc' => ['group_item' => SORT_DESC,'id_item'=>SORT_ASC],
                'default' => SORT_DESC,
                'label' => '<i class="fa fa-sort"></i>เรียงกลุ่มพัสดุ',
            ],
        ],
        ]);
       
        
        $data = yii::$app->request->post();
        if($commit_item != ""){
                $date = ($date?$date:date('Y-m-d'));
                $curs = $date;
                $curf = $date." 23:59:59.999";
                $model = senditem::find()->where(['and',['between', 'date_send', $date, $date." 23:59:59.999"],['not in','status_item','ลงทะเบียนฝากส่ง']])->orderBy($sort->orders)->limit(1000)->all();
                
           
        
        }else{
        return $this->redirect(["site/login"]);
        }
        //return $this->render('usergroupsave');
        $count = [];
        foreach ($model as $key => $row) {
          $item =  $row->idRegType->type_reg;
            if(array_key_exists($item,$count)){
             $count[$item] = $count[$item]+$row->qty_item; 
            }else{
                $count[$item] = $row->qty_item;
            }
        }
           return $this->render('getitem',['model'=>$model,'sort'=>$sort,'group'=>NULL,'groupcer'=>false,'count'=>$count,'date'=>$date]);
    


    }

    public function actionSetitem(){
      if(yii::$app->request->post()){
          $post = yii::$app->request->post();
          $model = senditem::find()->where(['id_item'=>$post['value']])->one();
          $title = "...";
          if($model->get_item){
            $model->get_item = 0;
            $title = 'dismiss';
          }else{
            $model->get_item = 1;
            $title = 'ok';
          }
          if($model->save()){
            $item = ['success'=>true,'title'=>$title];
            return Json::encode($item);
          }else{
            $title = 'ERROR PLZZZ TRY AGAIN!!!';
            $item = ['success'=>false,'title'=>$title];
            return Json::encode($item);
          }
      }else{

      }

    }



    public function actionMovegroup($id,$type,$date){
      $findgroup = '';
      if($type == 'ems'){
        $findgroup = 'lastdoc-'.$date;
      }else if($type == 'ลงทะเบียน'){
        $findgroup = 'reglast-'.$date;
      }

      $modelgroup =  groupsave::find()->where(['id_group'=>$findgroup])->one();
      if($modelgroup){
        $group_id_destination = $modelgroup->id;
       // $model = senditem::find()->where(['group_item'=>$id])->all();
          if(senditem::updateAll(['group_item_move'=>$group_id_destination],'group_item='.$id)){
            $modelgroup->status_group = 'certificated';
            $modelgroup->save();
            //stafftools/spgroup&id=10&type=reglast&date=2016-02-09
            return $this->redirect(['detailgroup','id'=>$id,'date'=>$date]);
          }

      }
    }

}
