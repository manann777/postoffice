<?php
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use app\models\DiaryTb;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
$this->registerJsFile('postoffice/web/js/gadpostoffice.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('postoffice/web/js/uploadpage.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = 'GAD POSTOFFICE::งานวันนี้';



if(Yii::$app->session->hasFlash('alertx')){
   echo Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alertx'), 'body'),
    'options'=>['class'=>'alert-warning']
    ]);
}

?>



<?php
$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success'];
$label = ['label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success'];

?>
<? // HELLO GIT ?>
<? $date = ($date?$date:date('Y-m-d'));
		 	$str = "";
		 	$icon ="";
		 	$movetool = false;
		  ?>
<div class="col-md-12">
	<div class="col-md-8"><strong>พัสดุฝากส่ง <?=$date?></strong></div>
	<div class="col-md-4">
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
				window.location.replace('?r=stafftools/worktoday&date='+date)
		     }",
		    ]
		]);
		?>


	</div>
</div>



   	<div class="table-responsive col-md-12">
   	<table class='table table-hover '>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>กลุ่ม</th>
			<!-- <th>หน่วยงาน</th> -->
			<th>จำนวนรายการ</th>
			<th>สถานะ</th>
			<th>เครื่องมือ</th>
			<th>เป็นเงิน</th>
			<th>หมายเหตุ</th>
			<th>#</th>
			
			

		</tr>
	</thead>
	<tbody>
		 
<?php foreach ($model as $key => $type): ?>

		 <tr> 
			<td><?=$type->id?></td> 

				<?php switch($type->type_doc){
		case 'airmail': echo '<td class="rowdata" data-href="stafftools/spgroup" data-val="'.$type->id.'" data-type="'.$type->type_doc.'" date="'.$date.'" >';
						$str = "<b class='text-danger'><u>จดหมายการบินไทย</u></b>";
						$icon ='<i class="fa fa-plane"></i>';
						$movetool = true;
		break;
		case 'lastdoc': echo '<td class="rowdata" data-href="stafftools/spgroup" data-val="'.$type->id.'" data-type="'.$type->type_doc.'" date="'.$date.'" >';
						$str = "<b class='text-danger'><u>กลุ่มย่อยemsและธรรมดา</u></b>";
						$icon = '<i class="fa fa-truck"></i>';
						$movetool = true;

					

		break;
		case 'reglast': echo '<td class="rowdata" data-href="stafftools/spgroup" data-val="'.$type->id.'" data-type="'.$type->type_doc.'" date="'.$date.'" >';
						$str = "<b class='text-danger'><u>กลุ่มย่อยลงทะเบียน</u></b>";
						$icon = '<i class="fa fa-certificate"></i>';
						$movetool = true;
		break;
		case 'itemdoc': echo '<td class="rowdata" data-href="stafftools/spgroup" data-val="'.$type->id.'" data-type="'.$type->type_doc.'" date="'.$date.'" >';
						$str = "พัสดุธรรมดา";
						$movetool = true;
		break;
		default : echo '<td class="rowdata" data-href="stafftools/detailgroup" data-val="'.$type->id.'" data-type="'.$type->type_doc.'"  date="'.$date.'">';
						$str = $type->id_group;
						$icon = '<i class="fa fa-tag"></i>';
						$movetool = false;
		break;
	 } ?><a class="<?='label '.$label[intval($type->id)%7]?>" ><?=$icon?></a> <?=$str?></td>
	
	 	<!-- 	<td><?=StringHelper::truncate($type->idUnitSender->name_unit,20,'..')?></td> -->
			<td><?=(array_key_exists($type->id,$result)?$result[$type->id]['counter']:0)?></td>
			<td><?php switch($type->status_group){
				case 'certificated':
				echo '<span class="badge badge-danger"> <i class="fa fa-list-ul"></i> รอการรับรอง</span>';
				break;
				case 'accepted':
				echo '<span class="badge badge-success"> <i class="fa fa-check-square-o"></i> รับแล้ว</span>'; 
				break;

			}?></td>
			<td>

				
			<div class="btn-group ">
                  <a class=" btn btn-primary getmodal"  href="#" value="<?=Url::to(['stafftools/upload','id' => $type->id])?>"><i class="fa fa-upload"></i> upload_file</a>
                  <?php 
					echo ($type->filepath?'<a href="'.Url::to('@web/'.$type->filepath).'" target=_blank class="btn btn-info "><i class="fa fa-paperclip"></i></a>':'');
					?>
                 <!--  <a class="btn btn-danger btn-xs delete"  href="<?= Url::to(['stafftools/deletegroup','id'=>$type->id_group]) ?>" id=<?=$type->id_group;?> ><i class="fa fa-trash-o fa-2"></i></a> -->
             </div>
         


			</td>
			<td><?=(array_key_exists($type->id,$resultsum)?$resultsum[$type->id]['sumter']:0)?></td>
			<td><?=StringHelper::truncate($type->comment,20,'...')?></td>
			<td><? if($movetool != true):?>
				
				
				<a class="getmodal label label-default" href="#"  value="<?=Url::to(['stafftools/movedate','id' => $type->id])?>"><i class="fa fa-clock-o fa-lg text-danger"></i></a>
				
			<? endif;?>
			</td>
		</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>


<?php

Modal::begin([

		    'id'=>'modal',
		    'size'=>'modal-lg',
		]);

		echo '<div id="modalcontent"></div>';

Modal::end();
 

?>
