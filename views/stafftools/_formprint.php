 
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
?>
 <?php $form = ActiveForm::begin([ 
		'id' => 'form_id', 
		'action'=> ['senditem/print'],
		
		'options' => [ 
		'class' => 'form_class form-inline well', 
		'enctype' => 'multipart/form-data', 
		'method' => 'post',

		], 
		]);  ?>
	<?php
	$type_doc_array = ['ลงทะเบียน'=>'ลงทะเบียน','ems'=>'EMS','airmail'=>'airmail','lastdoc'=>'EMSกับธรรมดา','reglast'=>'ลงทะเบียน','itemdoc'=>'พัสดุธรรมดา','airmailbkk'=>'airmailbkk'];

	?>

	<?= $form->field($model, 'type_doc')->radioList(array($model->type_doc => $type_doc_array[$model->type_doc]))->label('ประเภท',['class'=>'label label-primary']); ?>
	<div class="form-group">
	<label for="bookid"> <span class="label label-primary">
		<?php echo ($type_doc_array[$model->type_doc] != 'airmail'?'เลขเล่ม':'ส่งครั้งที่')?>
	</span> </label><br>
	<?= $form->field($model, 'number_book')->textInput()->label(false) ?>
	</div>
		
	<?=Html::hiddenInput('group',$group)?>
		<? if($type_doc_array[$model->type_doc] == 'airmail'):?>
		<div class="form-group">
		<label for="sender"><span class="label label-primary">ผู้ส่งเอกสาร</span></label><br>
		<?= Html::textInput('sender','',['class'=>'form-control','id'=>'sender']);?>
		</div>

		<div class="form-group">
		<label for="witness"><span class="label label-primary">พยาน</span></label><br>
		<?= Html::textInput('witness','',['class'=>'form-control','id'=>'witness']);?>
		</div>
	<? endif;?>
		<label>
		<?= Html::checkbox('printcheck',false,['value'=>'print','class'=>'checkbox110']); ?>
		สร้างไฟล์ PDF
		</label>
		<button type="submit" class="btn btn-default"><i class="fa fa-print"></i> บันทึก</button>
		
<?php ActiveForm::end(); ?>