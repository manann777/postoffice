<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\StringHelper;
	use kartik\date\DatePicker;
	
	$this->registerJsFile('postoffice/web/js/html2canvas041/build/html2canvas.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('postoffice/web/js/canvas2image/canvas2image.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('postoffice/web/js/tablereciver.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->title = 'GAD POSTOFFICE::แจ้งรับพัสดุ';
	$date = ($date?$date:date('Y-m-d'));
?>



<div class='col-md-6'><span><?  if($model_file):?>
<a href="<?=Url::to('@web/'.$model_file->file_path)?>" target='_blank' class="label label-info " ><i class="fa fa-paperclip"></i></a>
<? endif;?></span><strong> รับพัสดุวัน <?=$date?></strong></div>	
<div class="col-md-6"><?php
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
        window.location.replace('?r=site/index&date='+date)
         }",
        ]
    ]);


?></div>
<table class='table table-hover listTable table-list-mini' style="background-color:#FFF;text-align:justify;" id="the_canvas_element_id">
	<thead>
		<tr class="success">
			<th >#</th>
			<th>ชื่อหน่วยงาน</th>
			
			<th colspan='2'>ประเภทจดหมาย</th>
		
			
		</tr>
		<tr>
			<th colspan='2'><?=$date?></th>
			<!-- <th >ems</th> -->
			<th>ลงทะเบียน</th>
			<th>จดหมายธรรมดา</th>
			
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
			
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
 


