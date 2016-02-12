<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;

	$this->registerJsFile('postoffice/web/js/reciverform.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-md-12">

	<div class="col-md-6">ประจำวันที่ <?=$date?></div>
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
        window.location.replace('?r=diary/reciverform&date='+date)
         }",
        ]
    ]);
?>

	</div>
<table class='table table-hover recivertable'>
	<thead>
		<tr class="success">
			<th >#</th>
			<th>ชื่อหน่วยงาน</th>
			<th>ที่ตั้งหน่วยงาน</th>
			<th colspan='2'>ประเภทจดหมาย</th>
			<th>หมายเหตุ</th>
			<th>tools</th>
			
		</tr>
		<tr>
			<th colspan='3'></th>
			
			<th class="col-md-1">ลงทะเบียน</th>
			<th class="col-md-1">จดหมายธรรมดา</th>
			<th></th>
			<th></th>
		</tr>
		

	</thead>
	<tbody>
		<? $i = 0;?>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><!-- <?=$type->id_unit;?> --><?=++$i?></td>
			<td><?=StringHelper::truncate($type->name_unit,30,'..');?></td>
			<td><?=Html::encode($type->comment);?></td>
			
			<td><?=Html::input('number','qty_reg',(array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['qty_reg']:0),['step'=>1,'class'=>'form-control recivercon']);?></td>
			<td><?=Html::input('number','qty_manmail',(array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['qty_manmail']:0),['step'=>1,'class'=>'form-control recivercon']);?></td>

			<td><?=Html::input('text','comment',(array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['comment']:""),['class'=>'form-control recivercon']);?></td>
			<td><?=Html::checkbox('listitembox',false,['class'=>'listitembox checkbox110','value'=>$type->id_unit,'date'=>$date])?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr><td colspan='5'>
		</td>
		<td><?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block reciversubmit','date'=>$date]) ?></td>
		<td></td></tr>
	</tfoot>
</table>
 
</div>

<?php


?>