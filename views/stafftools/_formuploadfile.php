<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\DiaryTb;
use yii\helpers\StringHelper;


$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success'];
$label = ['label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success'];
$mail = 0;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="row">
    <div class="table-responsive col-md-12">
        <table class='table table-hover table-list-mini tableprice'>
           <thead>
           <tr class="success">
           <th class='col-md-1'>#</th>
                <th>ผู้ส่ง - ผู้รับ</th>
                <th>รหัสสำคัญ</th>
                <th>ประเภทพัสดุ</th>
                <th>ราคาชั่งเอง <a href="#" class="copyprice"><i class="fa fa-arrow-circle-right"></i></a></th>
                <th class='col-md-2'>ราคาจากไปรษณีย์</th>
           </tr>
           </thead> 
            <tbody>
            <?php 
            $sumprice = 0;
            $sumprice_own = 0;
            foreach($model_item as $key => $type):?>
                
                <?php if($type->id_reg_type != 4):?>
                <tr>
                    
                    <td><?=$type->id_item?></td>
                    <td><?=StringHelper::truncate($type->name_sender,20,'...')?> <i class="fa fa-arrow-right"></i> <?=StringHelper::truncate($type->name_receiver,20,'...')?>
                    <br><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span>
                    </td>
                    <td><?=$type->id_reg_item?></td>
                    <td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
                    <td class="preprice" data-price=<?=$type->price_item?> ><?=$type->price_item?></td>
                    <td><?= Html::textInput('post_price['.$type->id_item.']',$type->price_item_post,['class'=>'form-control post_price']); ?></td>
                    <? $sumprice += $type->price_item_post;
                         $sumprice_own += $type->price_item; ?>
                </tr>
                <?php endif;?>

            <?php endforeach; ?>

                <td></td><td></td><td></td>
                <td><a class="label-info label eshare" data=".post_price" datainput=".post_all_price">%</a> รวมราคา</td>
                <td><?=$sumprice_own?></td>
                <td><?= Html::textInput('post_all_price',$sumprice,['class'=>'form-control post_all_price']); ?></td>
                
            <?php 
            $sumprice = 0;
            $sumprice_own = 0;
            foreach($model_item as $key => $type):?>
                
                <?php if($type->id_reg_type == 4): $mail = 1; ?>
                <tr>
                    
                    <td><?=$type->id_item?></td>
                    <td><?=StringHelper::truncate($type->name_sender,20,'...')?> <i class="fa fa-arrow-right"></i> <?=StringHelper::truncate($type->name_receiver,20,'...')?>
                    <br><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span>
                    </td>
                    <td><?=$type->id_reg_item?></td>
                    <td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN> <span class='qtyman' data-qty='<?=$type->qty_item?>'><?=$type->qty_item?></span></td>
                    <td><?=$type->price_item?></td>
                    <td><?= Html::textInput('post_man_price['.$type->id_item.']',$type->price_item_post,['class'=>'form-control post_man_price']); ?></td>
                    <? $sumprice += $type->price_item_post;
                        $sumprice_own += $type->price_item; 
                    ?>
                </tr>
                <?php endif;?>

            <?php endforeach; ?>

            </tbody>
            <?php if($mail):?>
            <tr>
                <td></td><td></td><td></td>
                <td><a class="label-info label eshare" data=".post_man_price" datainput=".post_allman_price">%</a> <a class="label label-danger x3" data="" datainput="">x3</a> รวมราคา</td>
                <td><?=$sumprice_own?></td>
                <td><?= Html::textInput('post_allman_price',$sumprice,['class'=>'form-control post_allman_price']); ?></td>
            </tr>

            <tr class='success'>
                <td></td><td></td><td></td>
                <td> รวมราคา ทั้งหมด</td>
                <td></td>
                <td><?= Html::textInput('all_price','',['class'=>'form-control all_price']); ?></td>
            </tr>
            <?php endif;?>
        </table>

    </div>

</div>
<div class="row">

	<div class="col-md-12">
    
    <div class="col-md-4">
        <label for="imageFile" class="control-label">ไฟล์</label>
        <?=Html::fileInput('imageFile')?></div>
    
    <div class="col-md-4">
        <label for="comment" class="control-label">หมายเหตุ</label>
        <?= Html::textInput('comment',$model->comment,['class'=>'form-control'])?></div>
    <div class="col-md-4"><br><?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?></div>
</div>
   
	</div>
<?php ActiveForm::end() ?>

<br>