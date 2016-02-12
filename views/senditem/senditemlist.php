<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view; 
	use yii\bootstrap\Modal;
	use yii\helpers\StringHelper;
	use yii\helpers\ArrayHelper;
	$this->registerJsFile('postoffice/web/js/tablelist.js',['depends' => [\yii\web\JqueryAsset::className()]]);


	$this->title = 'GAD POSTOFFICE::พัสดุฝากส่ง'; 
	//$label = array('label label-normal','label label-default','label label-primary','label label-success','label label-info','label label-warning','label label-danger');
	$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube'];
	$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success'];
	$label = array('label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success');

	//$this->registerJsFile('postoffice/web/js/DataTables-master/media/js/jquery.dataTables.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	//$this->registerJsFile('postoffice/web/js/DataTables-master/media/js/dataTables.bootstrap.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	//$this->registerJsFile('postoffice/web/js/gadpostoffice.js',['depends' => [\yii\web\JqueryAsset::className()]]);

	
?>	


<?php if(Yii::$app->session->hasFlash('success')):?>
    <?= \yii\bootstrap\Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'body'),
    'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'options'),
    ])?>
<?php endif; ?>


<div class="col-md-12">

	<div class="col-md-6"> <!-- <?=$sort->link('group_item',['class'=>'btn btn-info']). ' ' . $sort->link('id_item',['class'=>'btn btn-primary']);?>  --><span class="<?='label '.$label[intval($groupsave->id)%7]?>" type="button"><i class="fa fa-tag"></i> <?=$groupsave->id_group?></span> - <span class="<?='label '.$label[intval($groupsave->id)%7]?>" type="button"><i class="fa fa-tag"></i> <?=$groupsave->id?></span></div>
	<div class="col-md-6 text-right" >
		<?php if($group && $groupcer != true): ?>
			<a class="btn btn-success" href="<?= Url::to(['senditem/addingroup','group'=>$group]) ?>">+เพิ่มพัสดุในกลุ่ม</a>
			<? if($groupsave->type_doc != 'airmailbkk'):?>
		 	<?=Html::a('<i class="fa fa-pencil-square-o"></i>รับรองเอกสาร',Url::to(['senditem/commit','group'=>$group]),['class'=>'btn btn-danger']);?>
			<?else:?>
		 	<?=Html::a('<i class="fa fa-pencil-square-o"></i>รับรองเอกสาร',Url::to(['senditem/commitbkk','group'=>$group]),['class'=>'btn btn-danger']);?>
			<?php endif; ?>
		<?php endif; ?>
</div></div>

<div class="col-md-12 ">

<table class='table table-hover listTable'>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>ชื่อผู้ฝากส่ง</th>
			<th>ชือผู้รับ</th>
			<!-- <th>หมายเลขพัสดุ</th> -->
			<th>ประเภท</th>
			<th>จำนวน</th>
			<th>วันที่ฝากส่ง</th>
			<th>สถานะ</th>
			<th class='col-md-1'>tools</th>

		</tr>
	</thead>
	<tbody><? $i = 0;?>
		<?php foreach ($model as $key => $type): ?>

		<tr>
			
			<td>
				<?=++$i?>
				<!-- <small><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></small>--></td>
			<td class='col-md-2' ><?=StringHelper::truncate(Html::encode($type->name_sender),20,'...');?><br><small class="<?='label '.$label[intval($type->group_item)%7]?>"><?=StringHelper::truncate( $type->idUnitSender->name_unit, 25,'...',null,false );?></small></td>
			<td><?=StringHelper::truncate(Html::encode($type->name_receiver),20,'...');?><br><small><?=$type->destiny_code?></small></td>
			<!-- <td><?=Html::encode($type->id_reg_item);?></td> -->
			<td><?=$type->idRegType->type_reg?></td>
			<td><?=$type->qty_item?></td>
			<td><?=Html::encode($type->date_send);?></td>
			 <td><small><i class="fa fa-clock-o text-info"></i> <?=$type->last_update?></small><br>
			 	<?php switch($type->status_item){
			case "รับรองเอกสาร":  echo " <span class='label label-primary'><i class='fa fa-lock'></i> รับรองเอกสารแล้ว</span>"; break;
			case "บันทึกรับ":  echo " <span class='label label-success'><i class='fa fa-check-square'></i> เจ้าหน้าที่บันทึกรับแล้ว</span>"; break;
			} ?></td>
			<td><div class="btn-group">
				
				<?php if($type->status_item == "ลงทะเบียนฝากส่ง"): ?>
				<a class="btn btn-success" href="<?= Url::to(['senditem/clone','id'=>$type->id_item]) ?>" ><i class="fa fa-files-o"></i></a>
				<a class="btn btn-info" href="<?= Url::to(['senditem/update','id'=>$type->id_item]) ?>"><i class="fa fa-wrench fa-2"></i></a>
				<a class="btn btn-danger delete" href="<?= Url::to(['senditem/delete','id'=>$type->id_item]) ?>" id=<?=$type->id_item;?> ><i class="fa fa-trash-o fa-2"></i></a>
				<?php endif; ?>	
			</div></td>
		</tr>
	<?php endforeach; ?>
	</tbody>

</table>
 <div class="col-md-12 well">

 <ul class="list-inline">
  
 <?php
		foreach($count as $key=>$value){
			echo '<li>'.$key.' '.$value.'</li>';
		}

		?>
		</ul>
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