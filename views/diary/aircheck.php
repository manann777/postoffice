<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;
	$this->registerJsFile('postoffice/web/js/tablereciver.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->title = 'GAD POSTOFFICE::แจ้งรับพัสดุการบินไทย';
?>

<div class="col-md-12">

	
	<div class="col-md-6">
			<?php
    echo DatePicker::widget([
        'name' => 'check_date',
        'removeButton' => false,
        'language' => 'th',

        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'maxDate'=>"+0D",

        ],
        'pluginEvents' => [
        "hide" => "function(e) {  //alert(e.format('yyyy-mm-dd'))
          var date = e.format('yyyy-mm-dd');
        window.location.replace('?r=diary/aircheck&date='+date+'&mode=".$mode."')
         }",
        ]
    ]);


?>
</div>
<div class="col-md-6 text-right"><h4> เลขเล่ม <?=$number_book?> </h4></div>

<table class='table table-hover listTable '>
	<thead>
		<tr class="success">
			<th >#</th>
			<th>เลขที่หนังสือ</th>
			<th>ผู้ส่ง</th>
			<th>ผู้รับ</th>
			<th>หมายเหตุ</th>
			<th><a href="#" class="checkall">เลือกทั้งหมด</a></th>
			<th>ผู้ตรวจรับ</th>
			
		</tr>
		
		

	</thead>
	<tbody>

		<?php 
		$i = 0;
		foreach ($model as $key => $type): ?>
		<tr>
			<td> <?=++$i;?></td>
			<td><?=$type->id_reg_item;?></td>
			<td><?=$type->name_sender?></td>
			<td><?=$type->name_receiver?></td>
			<td><?=$type->item_comment?></td>
			<td><?=Html::checkbox('listitembox',($type->status_item == 'รับแล้ว'?true:false),['class'=>'listitembox checkbox110','value'=>$type->id_item,'date'=>$date])?>


			</td>
			<td><?php

			$str = $type->commit_item;
			$str_array = explode(',',$str);
			echo (isset($str_array[1])?$str_array[1]:"");

			?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr><td colspan='5'>
		</td>
		<td><?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block checksubmit','date'=>$date,'mode'=>$mode]) ?></td>
		<td></td>
	</tr>

	</tfoot>
</table>
 
</div>

<div class="row">
    <div class="col-md-3">
      <button type="button" class="btn btn-danger btn-block download_excel"><i class="fa fa-file-excel-o"></i> download excel</button>
    </div>
</div>
