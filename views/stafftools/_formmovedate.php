<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
?>
<div class="row">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
	<div class="col-md-12">
	
	<div class="col-md-3"><?= $form->field($model,'date_create')->textInput(['readonly'=>'readonly','name'=>'old_date']);?></div>
	<div class="col-md-1"><i class="fa fa-arrow-right"></i></div>
	<div class="col-md-3"><label for="">เป็นวันที่</label>
		<?php
		echo DatePicker::widget([
		    'name' => 'date_create',
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
	<div class="col-md-3"><br><?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?></div>
</div>
   
	</div>
<?php ActiveForm::end() ?>
</div>
<br>