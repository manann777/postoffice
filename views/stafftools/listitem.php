<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	//use yii\widgets\ActiveForm;
	//use yii\bootstrap\ActiveForm;
	use yii\web\view;
	use yii\bootstrap\Modal;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;
	$this->registerJsFile('postoffice/web/js/staffjs.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->title = 'GAD POSTOFFICE::จัดการพัสดุฝากส่ง'; 
	$label = array('btn-xs btn btn-normal','btn-xs btn btn-default','btn-xs btn btn-primary','btn-xs btn btn-success','btn-xs btn btn-info','btn-xs btn btn-warning','btn-xs btn btn-danger');
?>	


<?php
use yii\helpers\ArrayHelper;
?>

<?php if(Yii::$app->session->hasFlash('alert')):?>
    <?= \yii\bootstrap\Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
    'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ])?>
<?php endif; ?>


<div class="col-md-12">
	<div class="row">
	<div class="col-md-3">
		<div class="btn-group btn-group-lg" role="group">
		<?=$sort->link('group_item',['class'=>'btn btn-info']). ' ' . $sort->link('id_item',['class'=>'btn btn-primary']). ' ' . $sort->link('status_item',['class'=>'btn btn-warning']);?></div>
	</div>
	<div class="col-md-3"><b><!-- วันที่ <?php
	$sevendayback = date_create($date);
	$sevendayback = date_modify($sevendayback,'-7 day');
	echo date_format($sevendayback,'Y-m-d');
	?> ถึง <?=$date?>  -->

		วันที่ <?=$date?>
		</b></div>
	<div class="col-md-3">
		<?php
		echo DatePicker::widget([
		    'name' => 'check_date',
		    'removeButton' => false,
		   	'language' => 'th',
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true

		    ],
		    'pluginEvents' => [
		    "hide" => "function(e) {  //alert(e.format('yyyy-mm-dd'))
		    	var date = e.format('yyyy-mm-dd');
				window.location.replace('?r=stafftools/listitem&date='+date)
		     }",
		    ]
		]);
?>

	</div>
	<div class="col-md-3 text-right">
	<div class="btn-group btn-group-lg" role="group">
	<a class="btn btn-info compress" title="การรวมกลุ่ม/เพิ่มเข้ากลุ่ม ID ที่น้อยที่สุดจะถูกยึดเป็นหัวหน้ากลุ่ม "><i class="fa fa-compress"></i> รวมกลุ่ม</a>
	<a class="btn btn-danger deletechecked"><i class="fa fa-trash-o"></i> ลบ</a>
		</div>
	</div>
	</div>
<table class='table table-hover'>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>ชื่อผู้ฝากส่ง</th>
			<th>ชือผู้รับ</th>
			<th>หมายเลขพัสดุ</th>
			<th>ประเภท</th>
			<th>จำนวน</th>
			<th>วันที่ฝากส่ง</th>
			<th class='col-md-1'>tools</th>

		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $type): ?>

		<tr>
			
			<td>
				<?php switch($type->status_item){
				case "ลงทะเบียนฝากส่ง": echo "<i class='fa fa-user-plus text-warning'></i>"; break;
				case "รับรองเอกสาร":  echo " <i class='fa fa-lock text-danger'></i>"; break;
				case "บันทึกรับ":  echo " <i class='fa fa-check-square text-success'></i>"; break;
				} ?>
				<small><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></small>
				<?php  if($type->status_item == "รับรองเอกสาร"){
				echo Html::checkbox('listitembox',false,['class'=>'listitembox','value'=>$type->id_item]);	
						}
				?>
				<br>
				<div class="btn-group btn-group-xs">
				<a class="<?=$label[intval($type->group_item)%7]?>" href="<?= Url::to(['stafftools/listitem','groupmodel'=>$type->group_item])?>">G:<?=$type->group_item?></a>
				<a href="<?= Url::to(['stafftools/manage','groupmodel'=>$type->group_item])?>" class="btn btn-info"><i class="fa fa-cogs"></i></a>
				</div>
			</td>
			<td class='col-md-2' ><?=Html::encode($type->name_sender);?><br>
				<small class="<?=$label[intval($type->group_item)%7]?>"><?=StringHelper::truncate( $type->idUnitSender->name_unit, 25,'...',null,false );?></small></td>
			<td><?=Html::encode($type->name_receiver);?><br><small><?=$type->destiny_code?></small></td>
			<td><?=Html::encode($type->id_reg_item);?></td>
			<td><?=$type->idRegType->type_reg?></td>
			<td><?=$type->qty_item?></td>
			<td><?=Html::encode($type->date_send);?>
			 <br><small>last update:<?=$type->last_update?></small></td>
			<td><div class="btn-group">
				
				<a class="btn btn-info" href="<?= Url::to(['senditem/update','id'=>$type->id_item]) ?>"><i class="fa fa-wrench fa-2"></i></a>
				<a class="btn btn-danger delete" href="<?= Url::to(['senditem/delete','id'=>$type->id_item]) ?>" id=<?=$type->id_item;?> ><i class="fa fa-trash-o fa-2"></i></a>
				
			</div></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 <?php if($group): ?>

	<?=$this->render('_formprint',['model'=>$modelgroupsave,'group'=>$group])?>

<?php endif; ?>
</div>

<!-- Large modal -->
<?php

Modal::begin([

		    'id'=>'modal',
		    'size'=>'modal-lg',
		]);

		echo '<div id="modalcontent"></div>';

Modal::end();
 

?>