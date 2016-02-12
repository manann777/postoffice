<?php
use app\assets\AppAsset;
AppAsset::register($this);
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\helpers\StringHelper;
use kartik\export\ExportMenu;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\web\Session;
$this->title = 'GAD POSTOFFICE::รายงาน';





$this->registerJsFile('postoffice/web/js/tablelist.js',['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('postoffice/web/js/datatables_footer.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$countmail = 0;
?>
<?php $session = Yii::$app->session;?>
<?=Html::beginForm ( $action = Url::to(['report']), $method = 'post', $options = [] );?>
<div class="col-md-3">
	<label> หน่วยงาน</label>
<?= Html::textInput('unit','',['class'=>'setlist']);?>
</div><div class="col-md-3">
<label> รูปแบบการส่ง</label>
<?= Html::textInput('reg','',['class'=>'setreglist']);?>
</div>
<div class="col-md-2">
	<label> ตั้งแต่วันที่</label>
	<?php
		echo DatePicker::widget([
		    'name' => 'check_date_start',
		    'removeButton' => false,
		   	'language' => 'th',
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true
		        ],
		    
		]);
?>

</div>

<div class="col-md-2">
	<label> ถึงวันที่</label>
	<?php
		echo DatePicker::widget([
		    'name' => 'check_date_end',
		    'removeButton' => false,
		   	'language' => 'th',
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true
		        ],
		    
		]);
?>

</div>


<div class="col-md-2">
	<br>
	<?= Html::submitButton('Submit', ['class'=> 'btn btn-primary btn-block']) ;?>
</div>
<?=Html::endForm();?>
<div class="col-md-12 table-responsive">
	<table class='table table-hover listTable listTable-report table-list-mini' colomn_sum='6'>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>หน่วยงาน</th>
			<th>ผู้นำฝาก</th>
			<th>ผู้รับ</th>
			<th>ประเภทพัสดุ</th>
			<th>รหัสพัสดุ</th>
			<th>ราคาจากไปรษณีย์</th>
			<th>จำนวน</th>
			<th>วันที่รับฝาก</th>
			<th>ผู้รับรอง</th>
			

		</tr>
	</thead>

	

	<tbody>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><?=$type->id_item?></td>
			<td><?=StringHelper::truncate( $type->idUnitSender->name_unit, 25,'...',null,false );?></td>
			<td><?=$type->name_sender?></td>
			<td><?=$type->name_receiver?></td>
			<td><?=$type->idRegType->type_reg?></td>
			<?php if($type->idRegType->type_reg == 'ธรรมดา'){
					$countmail = $countmail+$type->qty_item;
			}?>
			 <td><small><?=$type->id_reg_item?></small></td>
			<td class='text-center'><?=$type->price_item_post?></td>
			<td><?=$type->qty_item?></td>
			<td><?=$type->date_send?></td>
			<td><?=$type->commit_item?></td>
			
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
	            <tr>
	                <th colspan="6" style="text-align:right">ผลรวม:</th>
	                <th></th>
	                <th></th>
	                <th></th>
	                <th></th>
	            </tr>
	        </tfoot>
</table>
</div>
<div class="row">
	<div class="col-md-3">
      <button type="button" class="btn btn-danger btn-block download_excel"><i class="fa fa-file-excel-o"></i> download excel</button>
    </div>

    <div class="col-md-6 well">

 <ul class="list-inline">
  
 <?php
		foreach($count as $key=>$value){
			echo '<li><i class="fa fa-chevron-right"></i>'.$key.' '.$count[$key].' รายการ </li>';
			if($key == 'ธรรมดา'){ echo $countmail.' ฉบับ';}
		}

		?>
		</ul>
	</div>
</div>



<?
if($session['level'] != 'user'){
$js_1 = "setTimeout(function(){
            controlreg.removeOption(3)
            controlreg.removeOption(5)
            controlreg.removeOption(7)
           	controlunit1.removeOption(0)
          

             },500) ";

$this->registerJs($js_1, View::POS_READY);

}else{
	$unit = $session['unit'];
	$js_1 = "setTimeout(function(){
            controlreg.removeOption(3)
            controlreg.removeOption(5)
            controlreg.removeOption(7)
         
           	controlunit1.setValue(".$unit.")
          	controlunit1.lock()

             },500) ";

$this->registerJs($js_1, View::POS_READY);

}?>
