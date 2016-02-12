<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;
	use yii\widgets\ActiveForm;
	
	$this->registerJsFile('postoffice/web/js/html2canvas041/build/html2canvas.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('postoffice/web/js/canvas2image/canvas2image.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('postoffice/web/js/tablereciver.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->title = 'GAD POSTOFFICE::แจ้งรับพัสดุ';
	$date = ($date?$date:date('Y-m-d'));
?>

<div class="col-md-12">

	<div class="col-md-6"><?= Html::a('แก้ไขรายงานแจ้งรับพัสดุ', ['diary/reciverform','date'=>$date],['class'=>'btn btn-info']) ?></div>
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
        window.location.replace('?r=diary/report&date='+date)
         }",
        ]
    ]);


?>

	</div>
<table class='table table-hover listTable' style="background-color:#FFF;text-align:justify;" id="the_canvas_element_id">
	<thead>
		<tr class="success">
			<th >#</th>
			<th>ชื่อหน่วยงาน</th>
			
			<th colspan='2'>ประเภทจดหมาย</th>
			<th>ที่ตั้งหน่วยงาน</th>
			<th>หมายเหตุ</th>
			
		</tr>
		<tr>
			<th colspan='2'><?=$date?></th>
			<!-- <th >ems</th> -->
			<th>ลงทะเบียน</th>
			<th>จดหมายธรรมดา</th>
			<th></th>
			<th></th>
		</tr>
		

	</thead>
	<tbody>

		<?php foreach ($model as $key => $type): ?>
		<tr>
			<td><i class="fa fa-caret-right"></i></td>
			<td><?=StringHelper::truncate($type->name_unit,30,'..');?></td>
			
			<td class="text-center">
				<?php
				echo (array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['qty_reg']:0);
				?>
			</td>
			<td class="text-center">
				<?php
				echo (array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['qty_manmail']:0);
				?>
			</td>
			<td><?=Html::encode($type->comment);?></td>
			<td>
				<?php
				echo (array_key_exists($type->id_unit,$result)?$result[$type->id_unit]['comment']:"");
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 
</div>

<div class="row">
    <div class="col-md-3">
      <button type="button" class="btn btn-danger btn-block download_excel"><i class="fa fa-file-excel-o"></i> download excel</button>
    </div>
    <div class="col-md-3">
      <button type="button" class="btn btn-success btn-block download_jpg"><i class="fa fa-file-excel-o"></i> download jpg</button>
    </div>
    <div class="col-md-6">
   	
   	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
   										'action'=>['diary/upload']]) ?>

    <?= $form->field($model_upload, 'imageFile')->fileInput() ?>

    <button>Submit</button>

	<?php ActiveForm::end() ?>

    </div>
</div>

<div id="imgs"></div>





