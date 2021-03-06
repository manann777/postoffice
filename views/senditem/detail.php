<?php 
	use yii\helpers\Html;
?>
<h4>รายละเอียด</h4>
<table class="table table-hover">
<thead>
<tr>
	<th>#</th>
	<th><?=$model->id_item;?></th>
</tr>
</thead>
<tbody>
<tr>
	<td>ชื่อผู้ฝากส่ง</td>
	<td><?=Html::encode($model->name_sender);?>
		<br><small><?=$model->idUnitSender->name_unit;?></small></td>
</tr>
<tr>
	<td>ชือผู้รับ</td>
	<td><?=Html::encode($model->name_receiver);?></td>
</tr>
<tr>
	<td>หมายเลขพัสดุ</td>
	<td><?=Html::encode($model->id_reg_item);?></td>
</tr>
<tr>
	<td>ประเภท</td>
	<td><?=$model->idRegType->type_reg?></td>
</tr>
<tr>
	<td>จำนวน</td>
	<td><?=$model->qty_item?></td>
</tr>
<tr>
	<td>รหัสปลายทาง</td>
	<td><?=Html::encode($model->destiny_code);?></td>
</tr>
<tr>
	<td>วันที่ฝากส่ง</td>
	<td><?=Html::encode($model->date_send);?></td>
</tr>
<tr>
	<td>ราคา</td>
	<td><?=Html::encode($model->price_item);?> บาท</td>
</tr>
<tr>
	<td>น้ำหนัก</td>
	<td><?=Html::encode($model->weight_item);?> กรัม</td>
</tr>
<tr>
	<td>หมายเหตุ</td>
	<td><?=Html::encode($model->item_comment);?></td>
</tr>
<tr>
	<td>สถานะ</td>
	<td><?=Html::encode($model->status_item);?><br><small><?=$model->last_update?></small></td>
</tr>
<tr>
	<td>ผู้รับรอง</td>
	<td><?=Html::encode($model->commit_item);?></td>
</tr>
<tr>
	<td>เจ้าหน้าที่</td>
	<td><?=$model->idStaff->name_staff?></td>
</tr>
</tbody>
</table>