<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view; 
	use yii\bootstrap\Modal;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;
	$this->registerJsFile('postoffice/web/js/tablelist.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('postoffice/web/js/getitem.js',['depends' => [\yii\web\JqueryAsset::className()]]);

	$this->title = 'GAD POSTOFFICE::พัสดุฝากส่ง'; 
	$label = array('label label-normal','label label-default','label label-primary','label label-success','label label-info','label label-warning','label label-danger');
	$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube','fa-plane'];
	$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success','label-success'];
	//$label = array('label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success');

	//$this->registerJsFile('postoffice/web/js/DataTables-master/media/js/jquery.dataTables.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	//$this->registerJsFile('postoffice/web/js/DataTables-master/media/js/dataTables.bootstrap.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	//$this->registerJsFile('postoffice/web/js/gadpostoffice.js',['depends' => [\yii\web\JqueryAsset::className()]]);

	
?>	
<div class="row">
	<div class="col-md-3"><?=$sort->link('group_item',['class'=>'btn btn-info']). ' ' . $sort->link('id_item',['class'=>'btn btn-primary']);?></div>
<div class="col-md-2">วันที่ <?=$date?></div>
<div class="col-md-4 text-right" >
		
		
		<?php
		echo DatePicker::widget([
		    'name' => 'check_date',
		    'removeButton' => false,
		   	'language' => 'th',
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true

		    ],
		    'pluginEvents' => [
		    "hide" => "function(e) {  //alert(e.format('yyyy-mm-dd'))
		    	var date = e.format('yyyy-mm-dd');
				window.location.replace('?r=stafftools/getitem&date='+date)
		     }",
		    ]
		]);
?>

	
</div></div>

<div class="col-md-12 table-responsive">
<table class='table table-hover listTable  table-list-mini ' >
	<thead>
		<tr class="success">
			
			<th class='col-md-1'><a href="#">#</a></th>
			<th>ชื่อผู้ฝากส่ง</th>
			<th>ชือผู้รับ</th>
			<th>รหัสไปรษณีย์</th>
			<!-- <th>หมายเลขพัสดุ</th> -->
			<th><a href="#">ประเภท</a></th>
			<th>จำนวน</th>
			<th><a href="#">วันที่ฝากส่ง</a></th>
			<th>รับพัสดุ</th>
			<th>กลุ่ม</th>
			

		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $type): ?>

		<tr>
			
			<td>
				<small><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></small>
				
				</td>
			<td  ><?=StringHelper::truncate(Html::encode($type->name_sender),20,'...');?></td>
			<td><?=StringHelper::truncate(Html::encode($type->name_receiver),20,'...');?></td>
			<td><small><?=$type->destiny_code?></small></td>
			<!-- <td><?=Html::encode($type->id_reg_item);?></td> -->
			<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
			<td><?=$type->qty_item?></td>
			<td><?=Html::encode($type->date_send);?></td>
			<td><input type="checkbox" class="checkbox111" name="listitembox" value="<?=$type->id_item?>" <?=($type->get_item?'checked':'')?> ></td>
			<td><a href="<?= Url::to(['senditem/senditemlist','groupmodel'=>$type->group_item])?>" class="<?=$label[intval($type->group_item)%7]?>" ><?=$type->groupItem->id_group?></a></td>
			
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
	</td></div>
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