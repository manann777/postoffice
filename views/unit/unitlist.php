<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view;
	$this->title = 'GAD POSTOFFICE::หน่วยงาน';
?>	
<div class="col-md-12">

	<?= Html::a('+เพิ่มหน่วยงาน', ['unit/create'],['class'=>'btn btn-info']) ?>
<table class='table table-hover'>
	<thead>
		<tr class="success">
			<th>#</th>
			<th>ชื่อหน่วยงาน</th>
			<th>ที่ตั้งหน่วยงาน /หมายเหตุ</th>
			<th class='col-md-1'>แก้ไข</th>
			<th class='col-md-1'>ลบ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><?=$type->id_unit;?></td>
			<td><?=Html::encode($type->name_unit);?></td>
			<td><?=Html::encode($type->comment);?></td>
			<td><a class="btn btn-info" href="<?= Url::to(['unit/update','id'=>$type->id_unit]) ?>"><i class="fa fa-wrench fa-2"></i></a></td>
			<td><a class="btn btn-danger delete" href="<?= Url::to(['unit/delete','id'=>$type->id_unit]) ?>" id=<?=$type->id_unit;?> ><i class="fa fa-trash-o fa-2"></i></a></td>

		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 
</div>


<?php

$this->registerJsFile('postoffice/web/js/gadpostoffice.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>