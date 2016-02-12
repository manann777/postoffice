
<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\MaskedInput;

//use app\web\themes\bootflat\assets\price;
//price::register($this);


?>
<?php 
$type_mail = $type;
if($type_mail != 'airmail'):?>
<div class="helpertools col-md-12 well">
	
	<div class="form-inline col-md-6">
		<div class="form-group">
    <label for="reg_id_start">รหัสพัสดุชุดแรก</label>
    <?php 
        echo MaskedInput::widget([
        'name' => 'input-1',
        'id'=>'reg_id_start',
        'mask' => 'AA999999999AA'
    ]);

    ?>
   
  </div>
  <a href="#" class="btn btn-default reg_gen">สร้างรหัส</a>
</div>

<div class="form-inline col-md-6">
		<div class="form-group">
    <label for="reg_id_book">เฉพาะเลขเล่ม</label>
    <?php 
        echo MaskedInput::widget([
        'name' => 'input-2',
        'id'=>'reg_id_book',
        'mask' => 'AA9999'
    ]);

    ?>
   
  </div>
  <a href="#" class="btn btn-default reg_genbook">สร้างรหัส</a>
</div>
  
	
	
</div>

<? endif;?>
<table class="table table-hover">
<thead>
		<tr class="success">
			<th>#</th>
			<th>ผู้ส่ง-ผู้รับ</th>
			<th>รูปแบบ</th>
			<th>เลข</th>
			<th>น้ำหนัก/กรัม</th>
			<th>ราคา</th>
			<th>tools</th>
		</tr>
</thead>
<? $i = 1;?>
<?php foreach ($model as $key => $type): ?>
	<tr>
		<td class='col-md-1'><small><?=$i;?></small></td>
		<td><small><?=$type->id_item;?>-<?=$type->name_sender?> <i class="fa fa-share"></i> <?=$type->name_receiver?></small><br>
			<small>รหัสปลายทาง : <?=$type->destiny_code?></small>
		</td>
		<td><?=($type->staff_do?'<i class="fa fa-check-circle-o text-success"></i>':'')?> <span class='reg_id' id='<?=$type->id_reg_type?>'><?=$type->idRegType->type_reg?></span></td>
		<td class='col-md-2'><?php
				
				echo  Html::textInput('id_reg_item',$type->id_reg_item,['class'=>'form-control input-sm staff_do']);
				
		?></td>
		<td class='col-md-2'>
				<?=Html::textInput('weight_item',$type->weight_item,['class'=>'form-control weight_control input-sm staff_do']);?>
		</td>
		<td class='col-md-1'>
				<?=Html::textInput('price_item',$type->price_item,['class'=>'form-control price_control input-sm staff_do']);?>
		</td>
		<!-- <td class='col-md-1'><a class="btn btn-primary staffupdate" iditem=<?=$type->id_item?> ><i class="fa fa-check-square"></i></a></td> -->
		<td ><?=Html::checkbox('listitembox',false,['class'=>'listitembox','value'=>$type->id_item,'class'=>'checkbox110'])?>
			
		</td>
	</tr>
	<? $i++;?>
<?php endforeach; ?>
<tbody>
</tbody>
</table>