<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view;
	$this->title = 'GAD POSTOFFICE::ประเภท';
?>	
<div class="col-md-6">
	<br>
	<?= Html::a('+เพิ่มประเภทพัสดุ', ['regtype/create'],['class'=>'btn btn-info']) ?>
<table class='table table-hover'>
	<thead>
		<tr class="success">
			<th>#</th>
			<th>ชื่อประเภท</th>
			<th>หมายเหตุ</th>
			<th class='col-md-1'>แก้ไข</th>
			<th class='col-md-1'>ลบ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($modelReglist as $key => $type): ?>
		<tr>
			<td><?=$type->id_reg;?></td>
			<td><?=$type->type_reg;?></td>
			<td><?=Html::encode($type->comment);?></td>
			<td><a class="btn btn-info" href="<?= Url::to(['regtype/update','id'=>$type->id_reg]) ?>"><i class="fa fa-wrench fa-2"></i></a></td>
			<td><a class="btn btn-danger delete" href="<?= Url::to(['regtype/delete','id'=>$type->id_reg]) ?>" id=<?=$type->id_reg;?> ><i class="fa fa-trash-o fa-2"></i></a></td>

		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 
</div>


<?php

$this->registerJsFile('postoffice/web/js/gadpostoffice.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>