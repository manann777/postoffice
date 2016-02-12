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
	.textcenter{
		text-align: center;
	}

</style>
<?php 
 $dateth = date_create($datecreate);
 $dateTH_array = array("ERROR","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"); 
 $dateM = $dateTH_array[date_format($dateth,'n')];
 $dateY = date_format($dateth,'Y') +543;
 $dateD = date_format($dateth,'d');
 $date_Th=$dateD." ".$dateM." ".$dateY;

?>
<body>
<div class="prt-10">
	<div class="prt-7">
		ใบรายการพัสดุ <?=$strbook?>
	</div>
	<div class="prt-3">
		ส่งครังที่ <?=$numberbook?>
	<br>
		วันที่ <?=$date_Th?>
	<br>

		
	</div>

</div>

<div class="prt-10" >

<table class='table table-hover' style="width:100%;">
	<thead>
		<tr class="success">
			
			<th width="5%">#</th>
			<th width="25%">เลขที่หนังสือส่ง</th>
			<th width="30%">จาก</th>
			
			<th width="30%">ถึง</th>
			
			
			<th width="30%">หมายเหตุ</th>
			

		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1; 
		$total_price = 0;
		$qty_mail = 0;

		

		foreach ($model as $key => $type): ?>
		
		<?php $item_array[$type->idRegType->type_reg] = $item_array[$type->idRegType->type_reg]+$type->qty_item; ?>
		<tr>
			
			<td class="textcenter">
				<small><?php echo $i; $i++;?></small>
			</td>
			<td><?=Html::encode($type->id_reg_item);?></td>
			<td><?=Html::encode($type->idUnitSender->name_unit);?></td>
			<td><?=Html::encode($type->name_receiver);?></td>
			
			
			
			
			
			 <td><?=Html::encode($type->item_comment);?></td>
		
		</tr>
	

	<?php endforeach; ?>
		
	</tbody>
	<tfoot>
		<tr><td colspan='5' >**</td></tr>
		<tr><td colspan='5' class='textright'>รวม <?=count($model)?> รายการ ห่อ.........กล่อง </td></tr>
	</tfoot>
</table>

</div>
<div class="summary prt-10">
	
<div class="strprice prt-7">
	
</div>
</div>
<div class="prt-10" style="font-size:18px;">

	<div class="prt-5 textcenter">ลงชื่อ......................................................ผู้ส่งเอกสาร<br>( <?=$sender?> )</div>
	
	<div class="prt-5 textcenter">ลงชื่อ......................................................ผู้รับเอกสาร<br>(..............................................................)</div>
	
	<div class="prt-5 textcenter">ลงชื่อ......................................................พยาน<br>( <?=$witness?> )</div>
	

</div>
<div class="prt-10">group <?=$group?></div>
</body>
