
<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use kartik\date\DatePicker;
//use app\web\themes\bootflat\assets\price;
//price::register($this);
$this->registerJsFile('postoffice/web/js/price.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="col-md-4">
<?php
 echo '<label class="control-label">Check Date</label>';
echo DatePicker::widget([
    'name' => 'check_date',
    'removeButton' => false,
   
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true

    ],
    'pluginEvents' => [
    "hide" => "function(e) {  //alert(e.format('yyyy-mm-dd'))
    	var date = e.format('yyyy-mm-dd');
		window.location.replace('?r=senditem/acceptitem&date='+date)
     }",
    ]
]);
?>
</div>




<div class='col-md-12'><h4>รายการในวันที่ <?=$date?></h4></div>
<table class="table table-hover">
<thead>
		<tr class="success">
			<th>#</th>
			<th>ผู้ส่ง-ผู้รับ</th>
			<th>รูปแบบ</th>
			<th>เลข</th>
			<th>น้ำหนัก/กรัม</th>
			<th>ราคา</th>
			<th>submit</th>
		</tr>
</thead>
<?php foreach ($model as $key => $type): ?>
	<tr>
		<td class='col-md-1'><small><?=$type->id_item;?></small></td>
		<td><small><?=$type->name_sender?> <i class="fa fa-share"></i> <?=$type->name_receiver?></small></td>
		<td><?=$type->idRegType->type_reg?></td>
		<td class='col-md-2'><?php
			
				echo  Html::textInput('id_reg_item',$type->id_reg_item,['class'=>'form-control input-sm']);
			
		?></td>
		<td class='col-md-2'>
				<?=Html::textInput('weight_item',$type->weight_item,['class'=>'form-control weight_control input-sm']);?>
		</td>
		<td class='col-md-1'>
				<?=Html::textInput('price_item',$type->price_item,['class'=>'form-control price_control input-sm','readonly'=>'readonly']);?>
		</td>
		<td class='col-md-1'><a class="btn btn-primary staffupdate" iditem=<?=$type->id_item?> ><i class="fa fa-check-square"></i></a></td>
	</tr>
<?php endforeach; ?>
<tbody>
</tbody>
</table>
