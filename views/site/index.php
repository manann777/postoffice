<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\Session;
$this->title = 'GAD POSTOFFICE';

?>
<?php $session = Yii::$app->session;?>
<div class="site-index">

  <button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
 เปิด/ปิด <i class="fa fa-youtube-play"></i>  youtube help 
</button>


<div class='row text-center collapse active' id="collapseExample">
      <?php
   echo $this->render('youtube');

    ?>
  </div>



    <div class="body-content">

      <?
    
    Yii::$app->formatter->locale = 'th_TH';
    $time =time();
    echo Yii::$app->formatter->asDate($time, 'full');
?>
        <div class="row">
            <div class="col-md-3">
              <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-4"><i class="fa fa-user fa-5x"> </i></div>
                <div class="col-md-8 text-right"><small>ยินดีต้อนรับ</small><br> <strong><?=$array_login['email']?></strong></div>
                </div>
            </div>
              <div class="panel-body">
                <div class="row">
                <div class="col-md-8">

                  <?php if ($session['groupwork'] != ""): ?>
                          <a href="<?=Url::to(['senditem/senditemlist','groupmodel'=>$session['groupwork']])?>" class="text-danger"><i class="fa fa-exclamation-triangle"></i> มีกลุ่มที่ไม่ได้รับรอง</a>

                        <?php else:?>
                         <a href="<?=Url::to(['senditem/create'])?>"><i class="fa fa-plus-square-o"></i> เพิ่มพัสดุ</a>
                        <?php endif;?>

                 </div>
                <?php if($array_login['login'] != false):?>
                <div class="col-md-4 text-right"><a href="<?=Url::to(['site/logout']);?>" >logout <i class="fa fa-unlock-alt"></i></a></div>
                <?php else:?>
                                <div class="col-md-4 text-right"><a href="<?=Url::to(['site/login']);?>" >login <i class="fa fa-unlock-alt"></i></a></div>
              <?php endif;?>
                </div>
              </div></div>
            </div>
            

            <div class="col-md-3">
              <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-6"><i class="fa fa-copy fa-5x"></i></div>
                <div class="col-md-6 text-right"><small>รายการ</small><br> <h5>พัสดุฝากส่ง</h5></div>
                </div>
            </div>
                        <a href="<?=Url::to(['senditem/usergroupsave']);?>" >
              <div class="panel-body">
                <span class="pull-left">รายการพัสดุ</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
                        </a>
            </div>
            </div>

            <div class="col-md-3">
              <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-6"><i class="fa fa-tasks fa-5x"></i></div>
                <div class="col-md-6 text-right"><small>today <?=date('Y-m-d')?></small><br> <h5>รายงาน</h5></div>
                </div>
            </div>
                     <a href="<?=Url::to(['stafftools/report']);?>">
              <div class="panel-body">
                <span class="pull-left">รายงาน</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
                    </a>
          </div>
            </div>

             <div class="col-md-3">
              <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-6"><i class=" fa fa-question-circle fa-5x"></i></div>
                <div class="col-md-6 text-right"><small>อื่นๆ</small><br> <h5>ช่วยเหลือ</h5></div>
                </div>
            </div>
                     

                       <a href="<?=Url::to(['site/youtube']);?>">
              <div class="panel-body">
                <div class="row">
                <div class="col-md-6"><i class="fa fa-youtube-play text-danger"></i> youtube help</div>
                <div class="col-md-6 text-right">about us <i class="fa fa-users"></i></div>
                </div>
              </div>
            </a>
                   
          </div>
            </div>
<div class="col-md-12">
  <div class="col-md-6">
  <?php
  echo $this->render('_listrecive',['model'=>$model_recive,'date'=>$date,'result'=>$result,'model_file'=>$model_file]);
   ?>
   </div>

   <div class="col-md-6">
    <?php
   echo $this->render('_list',['model'=>$model]);

    ?>

  </div>
</div>


<!-- admin  -->
<!-- <?php 
        $session = Yii::$app->session;
        $permitpass = $session['level'];
        ?>
        <?php
        if($permitpass == 'admin' || $permitpass == 'staff'):
?>
          <div class="col-md-3">
              <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-6"><i class=" fa fa-cubes fa-5x"></i></div>
                <div class="col-md-6 text-right"><small>admin</small><h5>จัดการพัสดุ</h5></div>
                </div>
            </div>
                     
              <div class="panel-body">
                <div class="row">
                <div class="col-md-6"><a href="<?=Url::to(['stafftools/listitem']);?>"> จัดการพัสดุ</a></div>
                <div class="col-md-6 text-right"><a href="<?=Url::to(['stafftools/groupsave']);?>">กลุ่มพัสดุ </a></div>
                </div>
              </div>
                   
          </div>
            </div>

            <div class="col-md-3">
              <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                <div class="col-md-4"><i class=" fa fa-calendar fa-5x"></i></div>
                <div class="col-md-8 text-right"><small>admin</small><h5>บันทึกประจำวัน</h5></div>
                </div>
            </div>
                     
              <div class="panel-body">
                <div class="row">
                <div class="col-md-6"><a href="<?=Url::to(['diary/form']);?>"> ลงบันทึก</a></div>
                <div class="col-md-6 text-right"><a href="<?=Url::to(['diary/table']);?>">ตารางบันทึก </a></div>
                </div>
              </div>
                   
          </div>
            </div>

            <div class="col-md-3">
              
                <div class="list-group">
                <a href="#" class="list-group-item active"><small><strong>ADMIN Tools</strong></small></a>
                <a href="<?=Url::to(['staff/stafflist']);?>" class="list-group-item"><small><strong> ผู้ปฏิบัติงาน</strong></small></a>
               <a href="<?=Url::to(['regtype/reglist']);?>"  class="list-group-item"><small><strong> กำหนดรูปแบบพัสดุ</strong></small></a>
                <a href="<?=Url::to(['unit/unitlist']);?>"  class="list-group-item"><small><strong> กำหนดหน่วยงาน</strong></small></a>
                </div>
              </div>
                   



<?php endif;?> -->
           
            
        </div>
        <!-- <div class="row">
            <a href="<?=Url::to(['senditem/create']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>เพิ่มพัสดุ</a>
             <a href="<?=Url::to(['senditem/senditemlist']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>รายการพัสดุ</a>
             <a href="<?=Url::to(['stafftools/listitem']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>adminจัดการพัสดุ</a>
                    <a href="<?=Url::to(['stafftools/groupsave']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>adminกลุ่มบันทึก</a>
                    <a href="<?=Url::to(['diary/form']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>adminบันทึกประจำวัน</a>
                    <a href="<?=Url::to(['diary/table']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i>adminตารางบันทึกประจำวัน</a>
            <a href="<?=Url::to(['stafftools/report']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i> รายงาน</a>
             <a href="<?=Url::to(['site/login']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i> login</a>
        </div> -->
  
    </div>
</div>
