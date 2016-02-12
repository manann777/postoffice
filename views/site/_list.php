<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube','fa-plane'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success','label-success'];
$label = array('label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success','label-success');

?>
   <div class="col-md-12">
   
   	<h4>พัสดุฝากส่งวันนี้</h4>
   	<div class="table-responsive">
   	<table class='table table-hover table-list-mini'>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>หน่วยงาน</th>
			<th>ผู้นำฝาก</th>
			<th>ผู้รับ</th>
			<th>ประเภทพัสดุ</th>
			<!-- <th>ราคาประเมิน</th> -->
			
			<!-- <th>สถานะ</th> -->
			<!-- <th>ผู้รับรองเอกสาร</th> -->
			<!-- <th>กลุ่ม</th> -->

		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><small><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a>
				</small></td>
			<td><?=StringHelper::truncate( $type->idUnitSender->name_unit, 25,'...',null,false );?></td>
			<td><?=$type->name_sender?></td>
			<td><?=$type->name_receiver?></td>
			<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN>
				<?php switch($type->status_item){
				case "ลงทะเบียนฝากส่ง": echo "<span class='label label-danger'  data-toggle='tooltip' data-placement='right' title=' ลงทะเบียนฝากส่ง'><i class='fa fa-unlock'></i></span>"; break;
				case "รับรองเอกสาร":  echo " <span class='label label-primary' data-toggle='tooltip' data-placement='right' title=' รับรองเอกสารแล้ว'><i class='fa fa-lock'></i></span>"; break;
				case "บันทึกรับ":  echo " <span class='label label-info' data-toggle='tooltip' data-placement='right' title=' บันทึกรับแล้ว'><i class='fa fa-check-square'></i></span>"; break;
				case "รับแล้ว":  echo " <span class='label label-info' data-toggle='tooltip' data-placement='right' title=' รับแล้ว'><i class='fa fa-check-square'></i></span>"; break;
				} ?>
				<a href="<?= Url::to(['senditem/senditemlist','groupmodel'=>$type->group_item])?>" class="<?='label '.$label[intval($type->group_item)%7]?>" data-toggle="tooltip" data-placement="right" title="<?=$type->groupItem->id_group?>" >g</a>
			</td>
			<!-- <td><?=$type->price_item?></td> -->
			
			<!-- <td><?php switch($type->status_item){
				case "ลงทะเบียนฝากส่ง": echo "<span class='label label-danger'><i class='fa fa-unlock'></i> ลงทะเบียนฝากส่ง</span>"; break;
				case "รับรองเอกสาร":  echo " <span class='label label-primary'><i class='fa fa-lock'></i> รับรองเอกสารแล้ว</span>"; break;
				case "บันทึกรับ":  echo " <span class='label label-info'><i class='fa fa-check-square'></i> บันทึกรับแล้ว</span>"; break;
				case "รับแล้ว":  echo " <span class='label label-info'><i class='fa fa-check-square'></i> รับแล้ว</span>"; break;
				} ?></td> -->
				<!-- <td><?=$type->commit_item?></td> -->
			<!-- <td><a href="<?= Url::to(['senditem/senditemlist','groupmodel'=>$type->group_item])?>" class="<?='label '.$label[intval($type->group_item)%7]?>" ><?=$type->groupItem->id_group?></a></td> -->
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

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

