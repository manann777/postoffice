<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
// use app\assets\AppAsset; asset เดิม
use app\web\themes\bootflat\assets\bootflat;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;
use yii\widgets\Block;
use yii\web\Session;


/* @var $this \yii\web\View */
/* @var $content string */

bootflat::register($this);
?>
<?php $this->beginPage() ?>
<?php $session = Yii::$app->session;?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php  /*
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-fixed',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
     */ ?>

     <div class="row">
                <nav role="navigation" class="navbar navbar-custom">
                  <div class="container">
                    <div class="navbar-header">
                      <button data-target="#bsnavbar-collapse-3" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars text-info fa-2x"></i>
                      </button>
                      <a href="<?=Url::to(['site/index'])?>" class="navbar-brand">GAD PostOffice</a>
                    </div>
                    <div id="bsnavbar-collapse-3" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                      <?php if($session['level'] != 'staffbkk'):?>
                        <?php if ($session['groupwork'] != ""): ?>
                          <li><a href="<?=Url::to(['senditem/senditemlist','groupmodel'=>$session['groupwork']])?>" class="text-danger"><i class="fa fa-exclamation-triangle"></i> มีกลุ่มที่ไม่ได้รับรอง</a></li>

                        <?php else:?>
                         <li><a href="<?=Url::to(['senditem/create'])?>"><i class="fa fa-plus-square-o"></i> เพิ่มพัสดุ</a></li>
                        <?php endif;?>
                      <?php endif;?>
                        <li><a href="<?=Url::to(['senditem/usergroupsave'])?>"><i class="fa fa-copy"></i> รายการพัสดุ</a></li>
                        <li><a href="<?=Url::to(['stafftools/report'])?>"><i class="fa fa-tasks"></i> รายงาน</a></li>
                        <li><a href="<?=Url::to(['site/about'])?>"><i class="fa fa-question-circle"></i> เกี่ยวกับเรา</a></li>

                        <li><?php echo ($session['id'] !="" ? Html::a('<i class="fa fa-unlock-alt"></i> Logout', ['/site/logout']):Html::a('<i class="fa fa-unlock-alt"></i> Login', ['/site/login']));?></li>

                        

                        <!-- <li><?= Html::a('เพิ่มพัสดุ', ['/senditem/create']) ?></li>
                         <li><?= Html::a('รายการพัสดุ', ['/senditem/senditemlist']) ?></li>
                         <li><?= Html::a('รายงาน', ['/stafftools/report']) ?></li>
                         <li><?= Html::a('about us', ['/site/about']) ?></li>
                         <li><?php echo ($session['id'] !="" ? Html::a('Logout', ['/site/logout']):Html::a('Login', ['/site/login']));?></li>
                         -->  
                         
                        <!-- <li class="disabled"><a href="#">Link</a></li>  -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                   <!--  <?php if($session['level'] == 'admin' || $session['level'] == 'staff'):?>
                                     <li class="dropdown">
                                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Admin Tools <span class="caret"></span></a>
                                     <ul class="dropdown-menu">
                   <li><a  href="<?=Url::to(['stafftools/listitem']);?>"> จัดการพัสดุ</a></li>
                   <li><a  href="<?=Url::to(['stafftools/groupsave']);?>"> กลุ่มพัสดุ</a></li>
                   <li><a  href="<?=Url::to(['diary/form']);?>"> ลงบันทึกประจำวัน</a></li>
                   <li><a  href="<?=Url::to(['diary/table']);?>"> ตารางบันทึกประจำวัน</a></li>
                   <li role="separator" class="divider"></li>
                   <li><a  href="<?=Url::to(['regtype/reglist']);?>"> รูปแบบพัสดุ</a></li>
                   <li><a  href="<?=Url::to(['staff/stafflist']);?>"> staff</a></li>
                   <li><a  href="<?=Url::to(['unit/unitlist']);?>"> หน่วยงาน</a></li>
                                     </ul>
                                     </li>
                                  <?php endif;?> -->
                    </ul>   
                    </div>
                  </div>
                </nav>
              </div>


<div class="topic">
    <div class="container">
<?php 
$param = Yii::$app->params['customparam'];
echo $this->render($param);
?>

    </div>
    <div class="mailline"></div>
    </div>
  
</div> 


<div class="row mainbody">
        <div class="container" >
          
            <?= $content ?>
        </div>
 </div> 



 <?php if($session['level'] == 'admin'):?>

 <div class="kc_fab_wrapper">
</div>


<nav class="navbar  navbar-fixed-bottom navbar-inverse">
  <div class="container">
              <div class="navbar-header">
                      <button data-target="#bsnavbar-collapse-4" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars text-info fa-2x"></i>
                      </button>
                      <a href="<?=Url::to(['site/index'])?>" class="navbar-brand">Admin tools</a>
                    </div>
                    <div id="bsnavbar-collapse-4" class="collapse navbar-collapse">

    <ul class="nav navbar-nav">
      <li><a href="<?=Url::to(['stafftools/getitem']);?>"> ค้นหาและยืนยันพัสดุ</a></li>
      <li><a href="<?=Url::to(['stafftools/worktoday']);?>"> งานวันนี้</a></li>
      

     <!--  <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> บันทึก <span class="caret"></span></a>
         <ul class="dropdown-menu">
           <li><a href="<?=Url::to(['diary/table']);?>"> ตารางบันทึกประจำวัน</a></li>
         <li><a href="<?=Url::to(['diary/report']);?>"> แจ้งรับจดหมายและพัสดุ</a></li>
       <li><a href="<?=Url::to(['diary/aircheck']);?>"> แจ้งรับการบินไทย กทม-ขก</a></li>
       <li><a href="<?=Url::to(['diary/aircheck','view'=>'kk']);?>"> รายงานรับการบินไทย ขก-กทม</a></li>
         </ul>
       </li> -->


     
    <!-- <li><a  href="<?=Url::to(['stafftools/listitem']);?>"> จัดการพัสดุ</a></li>
    <li><a  href="<?=Url::to(['stafftools/groupsave']);?>"> กลุ่มพัสดุ</a></li>
    <li><a  href="<?=Url::to(['diary/form']);?>"> ลงบันทึกประจำวัน</a></li>
    <li><a  href="<?=Url::to(['diary/table']);?>"> ตารางบันทึกประจำวัน</a></li> -->
   <!--  <li><a> |</a></li> -->
   <!--  <li><a  href="<?=Url::to(['regtype/reglist']);?>"> รูปแบบพัสดุ</a></li> -->
  <!--   <li><a  href="<?=Url::to(['staff/stafflist']);?>"> staff</a></li>
  <li><a  href="<?=Url::to(['unit/unitlist']);?>"> หน่วยงาน</a></li> -->
    </ul>
  </div>
</nav>

<?php elseif($session['level'] == 'staff'):?>

  <div class="kc_fab_wrapper">
</div>


<nav class="navbar  navbar-fixed-bottom navbar-inverse">
  <div class="container">
              <div class="navbar-header">
                      <button data-target="#bsnavbar-collapse-4" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars text-info fa-2x"></i>
                      </button>
                      <a href="<?=Url::to(['site/index'])?>" class="navbar-brand">STAFF tools</a>
                    </div>
                    <div id="bsnavbar-collapse-4" class="collapse navbar-collapse">

    <ul class="nav navbar-nav">
      <li><a href="<?=Url::to(['stafftools/getitem']);?>"> ค้นหาและยืนยันพัสดุ</a></li>
       <li><a href="<?=Url::to(['stafftools/worktoday']);?>"> งานวันนี้</a></li>
      

  


   <!--   <li><a href="<?=Url::to(['diary/table']);?>"> ตารางบันทึกประจำวัน</a></li>
   
       <li><a href="<?=Url::to(['stafftools/reportstaff'])?>"> รายงาน</a></li>
   <li><a href="<?=Url::to(['diary/report']);?>"> แจ้งรับจดหมายและพัสดุ</a></li>
       <li><a href="<?=Url::to(['diary/aircheck']);?>"> แจ้งรับการบินไทย กทม-ขก</a></li>
       <li><a href="<?=Url::to(['diary/aircheck','view'=>'kk']);?>"> รายงานรับการบินไทย ขก-กทม</a></li>
       <li><a> |</a></li>
   
       <li><a  href="<?=Url::to(['unit/unitlist']);?>"> หน่วยงาน</a></li> -->
    </ul>
  </div>
</nav>
<?php elseif($session['level'] == 'staffbkk'):?>
<nav class="navbar  navbar-fixed-bottom navbar-inverse">
  <div class="container">
              <div class="navbar-header">
                      <button data-target="#bsnavbar-collapse-4" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars text-info fa-2x"></i>
                      </button>
                      <a href="<?=Url::to(['site/index'])?>" class="navbar-brand">STAFFBkk tools</a>
                    </div>
                    <div id="bsnavbar-collapse-4" class="collapse navbar-collapse">

    <ul class="nav navbar-nav">
    <li><a href="<?=Url::to(['senditem/createbkk'])?>"> เพิ่มพัสดุการบินไทย</a></li>
    <li><a href="<?=Url::to(['diary/aircheck','mode'=>'airmail']);?>"> แจ้งรับการบินไทย ขก-กทม</a></li>
    <li><a href="<?=Url::to(['diary/aircheck','view'=>'bkk']);?>"> รายงานรับการบินไทย กทม-ขก</a></li>
    

    </ul>
  </div>
</nav>
<?php endif;?>



   <div class="footer footercustom">
         <div class="container">
                <div class="clearfix">
                  <div class="footer-logo"><a href="#"><img src="<?=Url::to('@web/images/en-kku50th.png')?>"></a></div>
                   <!-- <ul class="nav nav-pills">
                    <li ><a href="#">youtube help</a></li>
                    <li ><a href="#">รายละเอียดโครงการ</a></li>
                    <li ><a href="#">เกี่ยวกับระบบ</a></li>
                                     </ul> -->
                  <!-- <dl class="footer-nav">
                    <dt class="nav-title">ADMIN TOOLs</dt>
                    <dd class="nav-item"><a  href="<?=Url::to(['regtype/reglist']);?>"><i class="fa fa-arrows"></i> รูปแบบพัสดุ</a></dd>
                    <dd class="nav-item"><a  href="<?=Url::to(['staff/stafflist']);?>"><i class="fa fa-users"></i> staff</a></dd>
                    <dd class="nav-item"><a  href="<?=Url::to(['unit/unitlist']);?>"><i class="fa fa-university"></i> หน่วยงาน</a></dd>
                                   
                  </dl>
                  <dl class="footer-nav">
                    <dt class="nav-title">ABOUT</dt>
                    <dd class="nav-item"><a href="#">The Company</a></dd>
                    <dd class="nav-item"><a href="#">History</a></dd>
                    <dd class="nav-item"><a href="#">Vision</a></dd>
                  </dl>
                  <dl class="footer-nav">
                    <dt class="nav-title">GALLERY</dt>
                    <dd class="nav-item"><a href="#">Flickr</a></dd>
                    <dd class="nav-item"><a href="#">Picasa</a></dd>
                    <dd class="nav-item"><a href="#">iStockPhoto</a></dd>
                    <dd class="nav-item"><a href="#">PhotoDune</a></dd>
                  </dl>
                  <dl class="footer-nav">
                    <dt class="nav-title">CONTACT</dt>
                    <dd class="nav-item"><a href="#">Basic Info</a></dd>
                    <dd class="nav-item"><a href="#">Map</a></dd>
                    <dd class="nav-item"><a href="#">Conctact Form</a></dd>
                  </dl> -->
                </div>
                <div class="footer-copyright text-center">gad-kku.</div> 
              </div>
          <div class="footer-copyright">
            <div class="container">
           <!--  © 2014 Copyright Text
           <a class="grey-text text-lighten-4 right" href="#!">More Links</a> -->
            </div>
          </div>
        </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
