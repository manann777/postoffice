<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view;
	use yii\helpers\StringHelper;
	
	$this->title = 'GAD POSTOFFICE::พัสดุฝากส่ง'; 
	$label = array('label label-normal','label label-default','label label-primary','label label-success','label label-info','label label-warning','label label-danger');
	

	
?>	

<style type="text/css">
@page {
	margin-top: 0.5cm;
	margin-bottom: 1cm;
}
	.table,.table th,.table td{ 

		border: 1px solid black;
    	border-collapse: collapse; 
    	font-size: 18px;

	}
	.prt-3{
		width:30%;
		float: left;
	}
	.prt-4{
		width:40%;
		float: left;
	}
	.prt-5{
		width:50%;
		float: left;
	}
	.prt-6{
		width:60%;
		float: left;
	}
	.prt-7{
		width:70%;
		float: left;
	}
	.prt-10{
		width:100%;
		float: left;
		padding: 1em;
	}
	body{
		font-size: 16px;

	}
	.textright{
		text-align: right;
	}

</style>
<?php 
 $dateth = date_create($datecreate);
 $dateTH_array = array("ERROR","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"); 
 $dateM = $dateTH_array[date_format($dateth,'n')];
 $dateY = date_format($dateth,'Y') +543;
 $dateD = date_format($dateth,'d');
 $date_Th=$dateD." ".$dateM." ".$dateY;
 $item_array= ['ลงทะเบียน'=>0,'EMS'=>0,'ธรรมดา'=>0,'การบินไทย'=>0,'EMS+ใบตอบรับ'=>0,'ลงทะเบียน+ใบตอบรับ'=>0,'พัสดุธรรมดา'=>0];
 /*foreach ($model as $key => $row) {
          $item =  $row->idRegType->type_reg;
            if(array_key_exists($item,$count)){
             $count[$item] = $count[$item]+$row->qty_item; 
            }else{
                $count[$item] = $row->qty_item;
            }
        }*/
?>
<body>
<div class="prt-10">
	<div class="prt-7">ใบนำส่งสิ่งของทางไปรษณีย์โดยชำระค่าฝากส่งเป็นรายเดือน
		<br><b><?=$strbook?> <?=$numberbook?></b><br>
		ได้ฝากส่งสิ่งของส่งทางไปรษณีย์โดยชำระค่าบริการเป็นเงินเชื่อดังรายการต่อไปนี้
	</div>
	<div class="prt-3">วันที่ <?=$date_Th?>
		<br>สำนักงานอธิการบดี
		<br>ใบอนุญาติที่ 1/2552
		<br>ศฝ.ปณ.มหาวิทยาลัยขอนแก่น 
		<br>ฝากส่งครั้งที่........ของเดือนนี้
	</div>

</div>

<div class="prt-10" >

<table class='table table-hover' style="width:100%;">
	<thead>
		<tr class="success">
			
			<th width="5%">#</th>
			<th width="20%">ชือผู้รับ</th>
			<th>ปลายทาง</th>
			<th>หมายเลขพัสดุ</th>
			<th>ประเภท</th>
			<th>ค่าบริการ</th>
			<th width="20%">หมายเหตุ</th>
			

		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1; 
		$total_price = 0;
		$qty_mail = 0;

		

		foreach ($model as $key => $type): ?>
		<?php //$total_price += $type->price_item; ?>
		<?php if($type->idRegType->type_reg != 'ธรรมดา'):?>
		<?php $item_array[$type->idRegType->type_reg] = $item_array[$type->idRegType->type_reg]+$type->qty_item; ?>
		<tr>
			
			<td>
				<small><?php echo $i; $i++;?></small>
			</td>
			
			<td><?=Html::encode($type->name_receiver);?></td>
			<td><?=$type->destiny_code?></td>
			<td><?=Html::encode($type->id_reg_item);?></td>
			<td><?=$type->idRegType->type_reg?></td>
			
			 <td class='textright'></td>
			 <td><?=Html::encode($type->item_comment);?></td>
		
		</tr>
		<?php else: $qty_mail = $qty_mail+$type->qty_item;?>
	<?php endif;?>

	<?php endforeach; ?>
			<tr><td></td><td colspan=4>ไปรษณีย์ภัณฑ์ธรรมดา รวม Express จำนวน <?=$qty_mail?> ชิ้น</td></tr>
			<tr>
				<td colspan=4></td>
				
				<td>รวมค่าบริการ</td>
				<td>
					</td>
				<td></td>
			</tr>
	</tbody>
</table>

</div>
<div class="summary prt-10">
	
<div class="strprice prt-7">
	สรุปยอดฝากส่งครั้งนี้<br>
	(ตัวอักษร)<span>.......................................................................................................</span>
</div>
</div>
<div class="prt-10" style="font-size:18px;">
	<div class="prt-5">
	<table class="table prt-10">
		<tr>
			<td>ประเภท</td>
			<td colspan=2>ในประเทศ</td>
			<td colspan=2>ต่างประเทศ</td>
			<td>ยอดรวม</td>
		</tr>
		<tr>
			<td>บริการ</td>
			<td>ชิ้น</td>
			<td>เงิน(1)</td>
			<td>ชิ้น</td>
			<td>เงิน(2)</td>
			<td>1+2</td>
		</tr>
		<tr>
			<td>ลงทะเบียน</td>
			<td><?=$item_array['ลงทะเบียน']+$item_array['ลงทะเบียน+ใบตอบรับ']?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>EMS</td>
			<td><?=$item_array['EMS']+$item_array['EMS+ใบตอบรับ']?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>พัสดุ</td>
			<td><?=$item_array['พัสดุธรรมดา']?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>ธรรมดา</td>
			<td><?=$qty_mail?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>ยอดรวม</td>
			<td><?=$item_array['พัสดุธรรมดา']+$item_array['ลงทะเบียน']+$item_array['ลงทะเบียน+ใบตอบรับ']+$item_array['EMS']+$item_array['EMS+ใบตอบรับ']+$qty_mail?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>
	<div class="prt-5 sinager" style="text-align: center;" >
		<div>
		ได้ตรวจสอบความถูกต้องแล้ว
		<br>
		<br>ลงชื่อ......................................................................</br>
		<br>(เขียนตัวบรรจง)
		<br>ผู้รับผิดชอบในการฝากส่ง
		<br>ได้ตรวจสอบและรับฝากไว้ถูกต้องแล้ว
		<br><br>ลงชื่อ.......................................................................</br>
		</div>
		<div class="prt-10"><div style="text-align:left;" class="prt-5">ตราประจำวัน</div><div style="text-align:right;" class="prt-5">เจ้าหน้าที่รับฝาก</div></div>
	</div>

</div>
<div class="prt-12">group <?=$group?></div>
</body>
