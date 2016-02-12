<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\view;
	$this->title = 'GAD POSTOFFICE::รายชื่อเจ้าหน้าที่'; 
?>	
<div class="col-md-12">
	<br>
	<?= Html::a('+เพิ่มเจ้าหน้าที่', ['staff/create'],['class'=>'btn btn-info']) ?>
<table class='table table-hover'>
	<thead>
		<tr class="success">
			<th>#</th>
			<th>ชื่อ</th>
			<th>email</th>
			<th>level</th>
			<th class='col-md-1'>แก้ไข</th>
			<th class='col-md-1'>ลบ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><?=$type->id_staff;?></td>
			<td><?=Html::encode($type->name_staff);?></td>
			<td><?=Html::encode($type->email_staff);?></td>
			<td><?=Html::encode($type->level_staff);?></td>
			<td><a class="btn btn-info" href="<?= Url::to(['staff/update','id'=>$type->id_staff]) ?>"><i class="fa fa-wrench fa-2"></i></a></td>
			<td><a class="btn btn-danger delete" href="<?= Url::to(['staff/delete','id'=>$type->id_staff]) ?>" id=<?=$type->id_staff;?> ><i class="fa fa-trash-o fa-2"></i></a></td>

		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 
</div>


<?php

$this->registerJsFile('postoffice/web/js/gadpostoffice.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>