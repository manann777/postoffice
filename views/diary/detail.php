<?php 
	use yii\helpers\Html;
?>
<h4>รายละเอียด</h4>
<table class="table table-hover">
<thead>
<tr>
	<th>วันที่</th>
	<th><?=$model->diary_date;?></th>
</tr>
</thead>
<tbody>
<tr>
	<td>รับพัสดุจากการบินไทย</td>
	<td><?=$model->receive_airmail?> รายการ</td>
</tr>
<tr>
	<td>ส่งพัสดุไปกับการบินไทย</td>
	<td><?=Html::encode($model->send_airmail);?> รายการ</td>
</tr>
<tr>
	<td>ค่าใช้จ่ายในการส่งพัสดุไปกับการบินไทย</td>
	<td><?=Html::encode($model->price_airmail);?> บาท</td>
</tr>
<tr>
	<td>รับพัสดุ EMS</td>
	<td><?=$model->receive_ems?> รายการ</td>
</tr>
<tr>
	<td>ส่งพัสดุ EMS</td>
	<td><?=$model->send_ems?> รายการ</td>
</tr>
<tr>
	<td>รับพัสดุ ที่มีการลงทะเบียน</td>
	<td><?=Html::encode($model->receive_mailreg);?> รายการ</td>
</tr>
<tr>
	<td>ส่งพัสดุ ที่มีการลงทะเบียน</td>
	<td><?=Html::encode($model->send_mailreg);?> รายการ</td>
</tr>
<tr>
	<td>รับพัสดุ ธรรมดา</td>
	<td><?=Html::encode($model->receive_mail);?> ชิ้น</td>
</tr>
<tr>
	<td>ส่งพัสดุ ธรรมดา</td>
	<td><?=Html::encode($model->send_mail);?> ชิ้น</td>
</tr>
<tr>
	<td>ค่าใช้จ่ายส่งพัสดุ ธรรมดา</td>
	<td><?=Html::encode($model->mail_price);?> บาท</td>
</tr>
<tr>
	<td>พัสดุที่ส่งคืนไปที่ไปรษณีย์ลงทะเบียน</td>
	<td><?=Html::encode($model->sendback_post);?> รายการ</td>
</tr>
<tr>
	<td>พัสดุที่ส่งคืนไปที่ไปรษณีย์ธรรมดา</td>
	<td><?=Html::encode($model->sendback_postman);?> รายการ</td>
</tr>
<tr>
	<td>พัสดุที่ไปรษณีย์ส่งคืนกลับมาลงทะเบียน</td>
	<td><?=Html::encode($model->return_post);?> รายการ</td>
</tr>
<tr>
	<td>พัสดุที่ไปรษณีย์ส่งคืนกลับมาธรรมดา</td>
	<td><?=Html::encode($model->return_postman);?> รายการ</td>
</tr>
<tr>
	<td>หมายเหตุ</td>
	<td><?=Html::encode($model->comment)?></td>
</tr>
</tbody>
</table>