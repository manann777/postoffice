<?php

namespace app\controllers;
use app\models\SendItem;
use app\models\Unit;
use app\models\GroupSave;
use yii\helpers\ArrayHelper;
use yii;
use yii\db\Query;
use yii\data\Sort;
use mPDF;
use yii\db\BaseActiveRecord;
use yii\helpers\Url;
date_default_timezone_set('Asia/Bangkok');

class SenditemController extends \yii\web\Controller
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCreate()
    {

        $model = new senditem;

        if(yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $model->date_send = date('Y-m-d H:i:s');
            $model->last_update = date('Y-m-d H:i:s');
            $model->id_staff = 0;
            $model->status_item = 'ลงทะเบียนฝากส่ง';
            $model->commit_item = Yii::$app->request->getUserIP();
            $model->group_item = 0;
            if($model->save()){
                $session = Yii::$app->session;
             
               // $session['groupwork'] = $model->id_item;
               //$model->group_item = $model->id_item;
              // $model->save();

               
            $groupmodel = new groupsave;
            $groupmodel->id_group = "ยังไม่ได้รับรอง-".date('Y-m-d');
            $groupmodel->type_doc = 'ยังไม่ได้จัดประเภท';
            $groupmodel->number_book = 'ยังไม่มีหมายเลข';
             $groupmodel->date_update = date('Y-m-d');
              //$groupmodel->date_create = date('Y-m-d');
            $groupmodel->status_group = 'nocertified';
            $groupmodel->email_owner = Yii::$app->request->getUserIP();
            $groupmodel->group_owner = $model->id_unit_sender;
            if($groupmodel->save()){

               $session['groupwork'] = $groupmodel->id;
               $model->group_item = $groupmodel->id;
               $model->group_item_move = $groupmodel->id;
               $model->save();
            }

                return $this->redirect(['senditemlist','groupmodel'=>$model->group_item]);
                
            }
        }
        
        return $this->render('create',['model'=>$model]);
    }


    public function actionCreatebkk(){
        

        $model = new senditem;

        if(yii::$app->request->post()){
            print_r(yii::$app->request->post());
            $model->load(Yii::$app->request->post());
            $model->date_send = date('Y-m-d H:i:s');
            $model->last_update = date('Y-m-d H:i:s');
            $model->id_staff = 0;
            $model->status_item = 'ลงทะเบียนฝากส่ง';
            $model->commit_item = Yii::$app->request->getUserIP();
            $model->group_item = 0;

                 if($model->save()){
                       
                    $groupmodel = groupsave::find()->where(['id_group'=>'airmailbkk-'.date('Y-m-d')])->one();
                    if($groupmodel == null){
                    $groupmodel = new groupsave;
                }
                    $groupmodel->id_group = "airmailbkk-".date('Y-m-d');
                    $groupmodel->type_doc = 'airmailbkk';
                    $groupmodel->number_book = 'ยังไม่มีหมายเลข';
                     $groupmodel->date_update = date('Y-m-d');
                      //$groupmodel->date_create = date('Y-m-d');
                    $groupmodel->status_group = 'nocertified';
                    $groupmodel->email_owner = Yii::$app->request->getUserIP();
                    $groupmodel->group_owner = $model->id_unit_sender;
                    if($groupmodel->save()){

                       $session['groupwork'] = $groupmodel->id;
                       $model->group_item = $groupmodel->id;
                       $model->group_item_move = $groupmodel->id;
                       $model->save();
                    }

                       return $this->redirect(['senditemlist','groupmodel'=>$model->group_item]);
                        
                    }
                }

        return $this->render('createbkk',['model'=>$model]);

    }


    public function actionDelete($id)
    {
        $model = senditem::findOne($id);
        $group_item = $model->group_item;
        if($model->delete()){
            
            return $this->redirect(['senditem/senditemlist','groupsave'=>$group_item]);
        }else{
            echo 'false';
        }
    }

    

    public function actionSenditemlist($groupmodel = null)
    {   
        Yii::$app->params['customparam']='senditemlist';
       
         $sort = new Sort([
        'defaultOrder'=>['id_item'=>SORT_ASC],
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
         $group_cer = false;
       if(!$groupmodel){
        $model =  senditem::find()->orderBy($sort->orders)->all();
        
       }else{
       $model = senditem::find()->where(['group_item' => $groupmodel])->orderBy($sort->orders)->all();
       $groupsave = groupsave::findOne(['id'=>$groupmodel]);
       if($groupsave != NULL ){
        if($groupsave->status_group == 'certificated'  || $groupsave->status_group =='accepted'){$group_cer = true;}
        }
       }
        $count = [];
        foreach ($model as $key => $row) {
          $item =  $row->idRegType->type_reg;
            if(array_key_exists($item,$count)){
             $count[$item] = $count[$item]+1; 
            }else{
                $count[$item] = 1;
            }
        }
        //print_r($count);
        return $this->render('senditemlist',['model'=>$model,'sort'=>$sort,'group'=>$groupmodel,'groupcer'=>$group_cer,'count'=>$count,'groupsave'=>$groupsave]);
    }
    public function actionDetail($id)
    {   
        $model =  senditem::findOne($id);
        $listData=ArrayHelper::toArray($model);
        $jsonListdata = json_encode($listData);
        echo $jsonListdata;
    }

    public function actionCommit($group)
    {   //สร้างไฟล์ groupsave โดยสถานะ เป็น certificated
         $session = Yii::$app->session;
         $email = ($session['email'] !=""?$session['email']:false);
         echo $email;
         if($email != false){

         }else{
            return $this->redirect(['site/login']);
          
         }

        $groupmodel  = groupsave::findOne(['id'=>$group]);
        if($groupmodel == null){
            $groupmodel = new groupsave;
             $groupmodel->id_group = $email."-".date('Y-m-d');
             $groupmodel->type_doc = 'ยังไม่ได้จัดประเภท';
            $groupmodel->number_book = 'ยังไม่มีหมายเลข';
             $groupmodel->date_update = date('Y-m-d');
            $groupmodel->date_create = date('Y-m-d');
            $groupmodel->status_group = 'certificated';
            $groupmodel->email_owner = $email;
               
        }else{
            $groupmodel->date_create = date('Y-m-d');
            if($groupmodel->type_doc != 'airmailbkk'){
            $groupmodel->id_group = $email."-".date('Y-m-d');
            }
             $groupmodel->date_update = date('Y-m-d');
             $groupmodel->status_group = 'certificated';
             $groupmodel->email_owner = $email;

        }

      

                
        if($groupmodel->save()){

                $session->setFlash('success',[
                'body'=>'รับรองเอกสารเรียบร้อยแล้ว <a class="btn btn-warning" href="'.Url::to(['site/index']).'">กลับหน้าแรก</a> ',
                'options'=>['class'=>'alert-info']
                ]);

                $id_group = $groupmodel->id;
             if(senditem::updateAll(['status_item'=>'รับรองเอกสาร','commit_item'=>$email],['group_item'=>$id_group,'status_item'=>'ลงทะเบียนฝากส่ง'])){
                     $session = Yii::$app->session;
                    $session['groupwork'] = "";
                     return $this->redirect(['senditemlist','groupmodel'=>$id_group]);
                     
                }else{
                     return $this->redirect(['senditemlist','groupmodel'=>$id_group]);
                }

       }

    }





     public function actionCommitbkk($group)
    {   //สร้างไฟล์ groupsave โดยสถานะ เป็น certificated
         $session = Yii::$app->session;
         $email = ($session['email'] !=""?$session['email']:false);
         echo $email;
         if($email != false){

         }else{
            return $this->redirect(['site/login']);
          
         }

        $groupmodel  = groupsave::findOne(['id'=>$group]);
        if($groupmodel == null){
            $groupmodel = new groupsave;
             $groupmodel->id_group = $email."-".date('Y-m-d');
             $groupmodel->type_doc = 'airmailbkk';
            $groupmodel->number_book = 'ยังไม่มีหมายเลข';
             $groupmodel->date_update = date('Y-m-d');
            $groupmodel->date_create = date('Y-m-d');
            $groupmodel->status_group = 'certificated';
            $groupmodel->email_owner = $email;
               
        }else{
            $groupmodel->date_create = date('Y-m-d');
            $groupmodel->id_group = "airmailbkk-".date('Y-m-d');
             $groupmodel->date_update = date('Y-m-d');
             $groupmodel->status_group = 'certificated';
             $groupmodel->email_owner = $email;

        }

      

                
        if($groupmodel->save()){

                $session->setFlash('success',[
                'body'=>'รับรองเอกสารเรียบร้อยแล้ว <a class="btn btn-warning" href="'.Url::to(['site/index']).'">กลับหน้าแรก</a> ',
                'options'=>['class'=>'alert-info']
                ]);

                $id_group = $groupmodel->id;
                $date = $groupmodel->date_create;
             if(senditem::updateAll(['status_item'=>'รับรองเอกสาร','commit_item'=>$email],['group_item'=>$id_group,'status_item'=>'ลงทะเบียนฝากส่ง'])){
                     $session = Yii::$app->session;
                    $session['groupwork'] = "";
                 return $this->redirect(['stafftools/spgroup','id'=>$id_group,'date'=>$date]);
                     
                }else{
                  return $this->redirect(['senditemlist','groupmodel'=>$id_group]);
                }

       }

    }
 
    public function actionUpdate($id)
    {
        


        $model = senditem::findOne($id);
        $group = $model->group_item;
        if(yii::$app->request->post()){
            
            $model->load(yii::$app->request->post());
            $model->last_update = date('Y-m-d H:i:s');

            if($model->save()){
                return $this->redirect(['senditemlist','groupmodel'=>$model->group_item]);
            }
        }
        $check_item_off = [0,0];
        $groupsave = groupsave::find()->where(['id'=>$group])->one();
        $grouptype = $groupsave->type_doc;
       // echo $grouptype;

        return $this->render('update',['model'=>$model,'setoff'=>$check_item_off,'grouptype'=>$grouptype]);

    }

    public function actionAddingroup($group,$insert = false,$date=null){
            $session = Yii::$app->session;
            $count_item_in_group_ems = senditem::find()->where(['and',['in','id_reg_type',[1,3]],['group_item'=>$group]])->all();
            $check_item_off = [0,0];
            if(count($count_item_in_group_ems)>4){
               // echo 'ems='.count($count_item_in_group_ems);
                $check_item_off = [2,5];
                $session->setFlash('warning',[
                'body'=>'เนื่องจากกลุ่มเอกสารนี้มีเอกสาร แบบems เป็นส่วนมาก ระบบได้ทำการปิดในส่วน แบบลงทะเบียน',
                'options'=>['class'=>'alert-danger']
                ]);
            }

            $count_item_in_group_reg = senditem::find()->where(['and',['in','id_reg_type',[2,5]],['group_item'=>$group]])->all();
            if(count($count_item_in_group_reg)>4){
                $check_item_off = [1,3];
                 $session->setFlash('warning',[
                'body'=>'เนื่องจากกลุ่มเอกสารนี้มีเอกสาร แบบลงทะเบียน เป็นส่วนมาก ระบบได้ทำการปิดในส่วน แบบems',
                'options'=>['class'=>'alert-danger']
                ]);
            }

            /*
            count ems  
            count reg
            */

            

            $clonemodel = new senditem;
            if(yii::$app->request->post()){
                 $clonemodel->load(Yii::$app->request->post());
                $clonemodel->date_send = date('Y-m-d H:i:s');
                $clonemodel->last_update = date('Y-m-d H:i:s');
                $clonemodel->id_staff = 0;
                if($insert != true){
                $clonemodel->status_item = 'ลงทะเบียนฝากส่ง';
                 $clonemodel->commit_item = Yii::$app->request->getUserIP();
                }else{
                  $clonemodel->status_item = 'รับรองเอกสาร'; 
                   $clonemodel->commit_item = $session['email']; 
                }
                $clonemodel->group_item = $group;
                $clonemodel->group_item_move = $group;
               
                if($clonemodel->save()){
            
                $groupmodel = $clonemodel->group_item;
                if($insert != true){
                return $this->redirect(['senditemlist','groupmodel'=>$groupmodel]);
                }else{
                $groupsave = groupsave::find()->where(['id'=>$group])->one();
                $groupsave->status_group = 'certificated';
                $groupsave->save();

                senditem::updateAll(['group_item_move' => $group], 'group_item ='.$group);
                 return $this->redirect(['stafftools/detailgroup','id'=>$groupmodel,'date'=>$date]);
                }
                }
            }else{

              $groupsave = groupsave::find()->where(['id'=>$group])->one();
            $grouptype = $groupsave->type_doc;
        //echo $grouptype;

            $clonemodel->group_item = $group;
            return $this->render('update',['model'=>$clonemodel,'setoff'=>$check_item_off,'grouptype'=>$grouptype]);
            

            }

            

    }
    public function actionClone($id)
    {   /*
        if($group != ""){
            $clonemodel->group_item = $group;
            return $this->render('update',['model'=>$clonemodel]);
        }*/
            $model = senditem::findOne($id);
            $group = $model->group_item;

         $session = Yii::$app->session;
            $count_item_in_group_ems = senditem::find()->where(['and',['in','id_reg_type',[1,3]],['group_item'=>$group]])->all();
            $check_item_off = [0,0];
            if(count($count_item_in_group_ems)>4){
               // echo 'ems='.count($count_item_in_group_ems);
                $check_item_off = [2,5];
                $session->setFlash('warningx',[
                'body'=>'เนื่องจากกลุ่มเอกสารนี้มีเอกสาร แบบems เป็นส่วนมาก ระบบได้ทำการปิดในส่วน แบบลงทะเบียน',
                'options'=>['class'=>'alert-danger']
                ]);
            }

            $count_item_in_group_reg = senditem::find()->where(['and',['in','id_reg_type',[2,5]],['group_item'=>$group]])->all();
            if(count($count_item_in_group_reg)>4){
                $check_item_off = [1,3];
                 $session->setFlash('warningx',[
                'body'=>'เนื่องจากกลุ่มเอกสารนี้มีเอกสาร แบบลงทะเบียน เป็นส่วนมาก ระบบได้ทำการปิดในส่วน แบบems',
                'options'=>['class'=>'alert-danger']
                ]);
            }



       
        
        if(yii::$app->request->post()){
             $clonemodel = new senditem;
            $clonemodel->load(Yii::$app->request->post());
            $clonemodel->date_send = date('Y-m-d H:i:s');
            $clonemodel->last_update = date('Y-m-d H:i:s');
            $clonemodel->id_staff = 0;
            $clonemodel->status_item = 'ลงทะเบียนฝากส่ง';
            $clonemodel->group_item = $model->group_item;
            $clonemodel->group_item_move  = $model->group_item;
            $clonemodel->commit_item = Yii::$app->request->getUserIP();
            if($clonemodel->save()){
            
               $groupmodel = $clonemodel->group_item;
                return $this->redirect(['senditemlist','groupmodel'=>$groupmodel]);
                
            }
        }
        //print_r($check_item_off); 
        $groupsave = groupsave::find()->where(['id'=>$group])->one();
        $grouptype = $groupsave->type_doc;
        echo $grouptype;
        return $this->render('update',['model'=>$model,'setoff'=>$check_item_off,'grouptype'=>$grouptype]);

    }



    public function actionDetailer($id){
            $model = senditem::findOne($id);
            return $this->renderAjax('detail',['model'=>$model]);
    }
    public function actionAcceptitem($date = null){
        
       
       if(!$date){
             $date = date('Y-m-d');
        } 
       // $curs = (!$date?date('Y-m-d'):$date);
        $curs = $date;
        $curf = $date." 23:59:59.999";
        $sql = "SELECT * FROM send_item WHERE date_send BETWEEN '".$curs."' AND '".$curf."'";
        $model = senditem::findBySql($sql)->all(); 

        return $this->render('acceptitem',['model'=>$model,'date'=>$date]);
    }


    public function actionStaffupdate(){
        $data = yii::$app->request->post();
        $date = date('Y-m-d H:i:s');
        $model = senditem::findOne($data['id_item']);
        $model->id_reg_item = $data['id_reg_item'];
        $model->weight_item = $data['weight_item'];
        $model->price_item = $data['price_item'];
       // $model->staff_do = 1;
        $model->last_update = $date;
      //  $model->status_item = 'บันทึกรับ';
        if($model->save()){
            $jsoncallback = array('success'=>true);
            echo json_encode($jsoncallback);
        }
        
    }

      public function actionPrint(){
        $session = Yii::$app->session;
        $sort = new Sort([
        'defaultOrder'=>['id_item'=>SORT_ASC],
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

        
       $sum = 0;
        if(yii::$app->request->post()){
            $sum = senditem::find()->where(['group_item_move' => $data['group']])->sum('price_item');
            $modelsend =  senditem::find()->where(['group_item_move' => $data['group']]);
            $model = groupsave::findOne(['id'=>$data['group']]);
            $date = $model->date_create;
            $post = yii::$app->request->post();
            $witness = (isset($post['witness'])?$post['witness']:"...........................................................");
            $sender = (isset($post['sender'])?$post['sender']:"...........................................................");
            /*if($model == null){
               $model = new groupsave;
                $model->id_group = $data['group'];
                $model->date_create = date('Y-m-d');
            }*/


               /* $model->type_doc = $data['radio'];
                $model->number_book = $data['bookid'];
                status_item = 'บันทึกรับ'; */
                //$modelsend->status_item = 'บันทึกรับ';

                /*echo 'count=>'.$modelsend->count();
                echo 'sum=>'.$modelsend->sum('get_item');*/

            if($modelsend->count() != $modelsend->sum('get_item')){
                Yii::$app->getSession()->setFlash('alert',[
                'body'=>'การบันทึกผิดพลาด..เราพบว่าจำนวนพัสดุที่รับไม่ครบถ้วน',
                'options'=>['class'=>'alert-danger']
                ]);
                return Yii::$app->getResponse()->redirect(['stafftools/spgroup','id'=>$data['group'],'date'=>$date]);
            }  


                if($model->date_create == null){
                    $model->date_create = date('Y-m-d');
                }

                $model->load(yii::$app->request->post());
                $model->date_update = date('Y-m-d');
                $model->status_group = 'accepted';
                $model->email_owner =$session['email'];
                $model->price_system = $sum;
               if($model->save()){
                        
                        senditem::updateAll(['status_item'=>'บันทึกรับ'],['group_item_move'=>$data['group'],'status_item'=>'รับรองเอกสาร']);

                         Yii::$app->getSession()->setFlash('alert',[
                        'body'=>'บันทึกกลุ่มเรียบร้อยแล้ว..',
                        'options'=>['class'=>'alert-success']
                        ]); 

               }else{
                 Yii::$app->getSession()->setFlash('alert',[
                'body'=>'การบันทึกผิดพลาด..',
                'options'=>['class'=>'alert-danger']
                ]);

               }
            

        }
        

       if(isset($data['printcheck']) && $data['printcheck'] == 'print'){
     
        $modelgroupsave = groupsave::findOne(['id'=>$data['group']]);
        $datecreate = $modelgroupsave->date_create;
        $model = senditem::find()->where(['group_item_move' => $data['group']])->orderBy($sort->orders)->all();
        $countitem = senditem::find()->where(['group_item_move' => $data['group']])->count();
        $mpdf = new mPDF('th');
        $type_doc_array = ['ลงทะเบียน'=>'ลงทะเบียน','ems'=>'EMS','airmail'=>'การบินไทย ขก-กทม','lastdoc'=>'EMS','reglast'=>'ลงทะเบียน','itemdoc'=>'พัสดุธรรมดา','airmailbkk'=>'การบินไทย กทม-ขก'];


       if($modelgroupsave->type_doc == 'airmail' || $modelgroupsave->type_doc == 'airmailbkk'){
        $mpdf->WriteHTML($this->renderPartial('printerairmail',['group'=>$data['group'],'model'=>$model,'strbook'=>$type_doc_array[$data['GroupSave']['type_doc']],'numberbook'=>$data['GroupSave']['number_book'],'sum'=>$sum,'datecreate'=>$datecreate,'witness'=>$witness,'sender'=>$sender]));
       
       }else{
        $mpdf->WriteHTML($this->renderPartial('printer',['group'=>$data['group'],'model'=>$model,'strbook'=>$type_doc_array[$data['GroupSave']['type_doc']],'numberbook'=>$data['GroupSave']['number_book'],'sum'=>$sum,'datecreate'=>$datecreate]));
       }
        $mpdf->Output('pdf/'.$data['group'].'mypdf.pdf', 'F');

        Yii::$app->getSession()->setFlash('alert',[
                'body'=>'ระบบได้ทำการบันทึกและสร้างไฟล์ pdf เรียบร้อยแล้ว..<a class="btn btn-danger" href="pdf/'.$data['group'].'mypdf.pdf" target="_blank" >download PDF</a>',
                'options'=>['class'=>'alert-success']
                ]);

           // Yii::$app->getResponse()->sendFile('pdf/'.$data['group'].'mypdf.pdf', $data['group'].'mypdf.pdf' , ['inline' => false])->send();

        // return Yii::$app->getResponse()->redirect(['stafftools/listitem','groupmodel'=>$data['group']]);
        return Yii::$app->getResponse()->redirect(['stafftools/spgroup','id'=>$data['group'],'date'=>$date]);
      
        
        }
     
        return Yii::$app->getResponse()->redirect(['stafftools/spgroup','id'=>$data['group'],'date'=>$date]);
        
    }


    public function actionUsergroupsave($date = null){
        Yii::$app->params['customparam']='usergroupsave';
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
            if($date != null){
                $curs = $date;
                $curf = $date." 23:59:59.999";
                $model = senditem::find()->where(['and',['between', 'date_send', $curs, $curf],['like','commit_item',$commit_item]])->orderBy($sort->orders)->limit(1000)->all();
                
            }else{
                $model = senditem::find()->where(['like','commit_item',$commit_item])->orderBy($sort->orders)->limit(1000)->all();
                $date = "ทั้งหมด";
            }
        
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
           return $this->render('usergroupsave',['model'=>$model,'sort'=>$sort,'group'=>NULL,'groupcer'=>false,'count'=>$count,'date'=>$date]);
    }

}
