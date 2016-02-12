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
use app\models\DiaryTb;






$this->registerJsFile('postoffice/web/js/tablelist.js',['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('postoffice/web/js/datatables_footer.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = 'GAD POSTOFFICE::รายงานstaff';
?>

<?=Html::beginForm ( $action = Url::to(['reportstaff']), $method = 'post', $options = [] );?>
		<div class="col-md-3">
		<label> หน่วยงาน</label>
		<?= Html::textInput('unit','',['class'=>'setlist']);?>
		</div><div class="col-md-3 setregdiv">
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
	<table class='table table-hover listTable listTable-report table-list-mini' colomn_sum='4'>
	<thead>
		<tr class="success">
			
			<th class='col-md-1'>#</th>
			<th>กลุ่ม</th>
			<th>ประเภทกลุ่ม</th>
			<th>วันที่</th>
			<th>จำนวนเงิน</th>
			<th>ผู้รับเรื่อง</th>
			<th>หมายเหตุ</th>
			<th>หน่วยงาน</th>

		</tr>
	</thead>

	

	<tbody>
		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><?=$type->id?></td>
			<td><?=$type->id_group?></td>
			<td><?=$type->type_doc?></td>
			<td><?=$type->date_create?></td>
			<td>
			<?=(array_key_exists($type->id,$resultsum)?$resultsum[$type->id]['sumter']:0)?>
			</td>
			<td><?=$type->email_owner?></td>
			<td><?=$type->comment?></td>
			<td><?=$type->idUnitSender->name_unit?></td>
			
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
            <tr>
                <th colspan="4" style="text-align:right">ผลรวม:</th>
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
</div>

<div class="col-md-12">

 <ul class="list-inline">
  
 <?php /*
		foreach($countmoney as $key=>$value){
			echo '<li><small>'.$key.' '.$countmoney[$key][0].' บาท / '.$countmoney[$key][1].' ครั้ง </small></li>';
		}

		  */ ?>
		</ul>
	</td></div>


	<div class="col-md-12">

 <ul class="list-inline">
  
 <?php  /*
		foreach($count as $key=>$value){
			echo '<li><small>'.$key.' '.$value.'ครั้ง </small></li>';
		}

		  */ ?>
		</ul>
	</td></div>
</div>
<?

$js_1 = "setTimeout(function(){
            
           	controlunit1.removeOption(0)
          $('.setregdiv').remove()

             },500) ";

$this->registerJs($js_1, View::POS_READY);?>