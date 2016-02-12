<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
//use yii\grid\Gridview;

//use kartik\widgets\Select2;
$this->registerJsFile('postoffice/web/js/tablelist_diary.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'GAD POSTOFFICE::บันทึกประจำวัน';
?>
<a href="<?=Url::to(['diary/form']);?>" class="btn btn-info"><i class="fa fa-envelope-o"></i> ลงบันทึกประจำวัน</a>


<div class="col-md-12 table-responsive">
<table class='table table-hover listTable table-list-mini'  >
  <thead>
        <tr class="success">
            
            <!-- <th class='col-md-1'>#</th> -->
            <th class='col-md-1'>date</th>
            <th class='col-md-1'>AR</th>
            <th class='col-md-1'>AS</th>
            <th class='col-md-1'>APrice</th>
            <!-- <th class='col-md-1'>ER</th> -->
            <th class='col-md-1'>ES</th>
            <th class='col-md-1'>RR</th>
            <th class='col-md-1'>RS</th>
            <th class='col-md-1'>MR</th>
            <th class='col-md-1'>MS</th>
            <th class='col-md-1'>MPrice</th>
            <th class='col-md-1'>PRR</th>
             <th class='col-md-1'>PRM</th>
            <th class='col-md-1'>PBR</th>
             <th class='col-md-1'>PBM</th>
            <th class='col-md-1'>comment</th>
            <th class='col-md-1'>recorder</th>
            <th class='col-md-1'>tools</th>
            

        </tr>
    </thead>  
    <tbody>
        <?php foreach ($model as $key => $type): ?>
        <tr>
       <!--    <td><?=$type->id_diary?></td> -->
            <td><a href="#" class="getmodal" value="<?=Url::to(['diary/detail','id' => $type->id_diary])?>" ><?=$type->diary_date?></a></td>
            <td><?=$type->receive_airmail?></td>
            <td><?=$type->send_airmail?></td>
            <td><?=$type->price_airmail?></td>
           <!--  <td><?=$type->receive_ems?></td> -->
            <td><?=$type->send_ems?></td>
            
            <td><?=$type->receive_mailreg?></td>
            <td><?=$type->send_mailreg?></td>
            <td><?=$type->receive_mail?></td>
            <td><?=$type->send_mail?></td>
            <td><?=$type->mail_price?></td>
            <td><?=$type->sendback_post?></td>
            <td><?=$type->sendback_postman?></td>
            <td><?=$type->return_post?></td>
            <td><?=$type->return_postman?></td>
            <td><?=StringHelper::truncate($type->comment,10,'...')?></td>
            
            <td><?=$type->writer?></td>
            <td>
                
               
                
                <a href="<?=Url::to(['diary/form','datetoday'=>$type->diary_date])?>" ><i class="fa fa-wrench fa-2"></i></a>
                <a id="" class="delete" href="<?=Url::to(['diary/delete','id'=>$type->id_diary])?>" ><i class="fa fa-trash-o fa-2"></i></a>
                
           

            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
    <tfoot >
            <tr class="info">
                <th>ผลรวม:</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
</table> 
</div>
<div class="row">
    <div class="col-md-3">
      <button type="button" class="btn btn-danger btn-block download_excel"><i class="fa fa-file-excel-o"></i> download excel</button>
    </div>
</div>

<!-- Large modal -->
<?php

Modal::begin([
           
            'id'=>'modal',
            'size'=>'modal-lg',
        ]);

        echo '<div id="modalcontent"></div>';

Modal::end();
?>