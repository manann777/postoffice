 <?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\StringHelper;

?>

 <?php

 $this->registerJsFile('postoffice/web/js/price.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 $this->registerJsFile('postoffice/web/js/getitem.js',['depends' => [\yii\web\JqueryAsset::className()]]);



$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube','fa-plane'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success','label-success'];
$label = ['label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success','label-success'];

?>


<?php if(Yii::$app->session->hasFlash('alert')):?>
    <?= \yii\bootstrap\Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
    'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ])?>
<?php endif; ?>
<div class="col-md-6">
	
	
	<?if($modelgroupsave->type_doc != 'airmailbkk'):?>
	<a  class="btn btn-success " href="<?=Url::to(['stafftools/worktoday','date'=>$date])?>"> <i class="fa fa-arrow-left"></i> กลับหน้างานวันที่ <?=$date?></a>

	<a value="<?=Url::to(['stafftools/setcode','id' => $group,'type'=>$modelgroupsave->type_doc])?>" class="btn btn-info getmodal">จัดการรหัสสำคัญ</a>
	<? endif;?>
</div>
 <div class="col-md-12">
    			    <div class="table-responsive">
		   	<table class='table table-hover table-list-mini listTable'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>รับพัสดุ</th>
				<th>หมายเหตุ</th>
				<th>เครื่องมือ</th>
				
			</tr>
			</thead>
			<tbody>
				<? $i = 1;?>
			<?php foreach ($model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$i?></a></td> 
					<td><?=$type->id_item?>-<?=StringHelper::truncate($type->name_sender,20,'...')?> <i class="fa fa-arrow-right"></i> <?=StringHelper::truncate($type->name_receiver,20,'...')?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					
					<td><input type="checkbox" class="checkbox111" name="listitembox" value="<?=$type->id_item?>" <?=($type->get_item?'checked':'')?> ></td>
					
					<td><?=$type->item_comment?></td>
					<td>
						<div class="btn-group">
				
				
				<a class="btn btn-info" href="<?= Url::to(['stafftools/updateitem','id'=>$type->id_item]) ?>"><i class="fa fa-wrench fa-2"></i></a>
				<a class="btn btn-danger delete" href="<?= Url::to(['stafftools/deleteitem','id'=>$type->id_item,'stage'=>'spgroup','date'=>$date]) ?>" id=<?=$type->id_item;?> ><i class="fa fa-trash-o fa-2"></i></a>
				
				</div>

					</td>
				</tr>
				<?$i++?>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
			<?php if(count($model)): ?>

		<?=$this->render('_formprint',['model'=>$modelgroupsave,'group'=>$group])?>

		<?php endif; ?>
    </div>
<!-- Large modal -->
<?php

Modal::begin([

		    'id'=>'modal',
		    'size'=>'modal-lg',
		    'footer'=>'<a class="btn btn-info approve-code">ยืนยัน</a>',
		    
		]);

		echo '<div id="modalcontent"  data-id="'.$group.'" date-value="'.$date.'"></div>';

Modal::end();
 

?>