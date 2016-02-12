

<? 
    use app\assets\AppAsset;
    AppAsset::register($this);
    use yii\web\View;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
   // use kartik\widgets\Select2;
 ?>
<div class="col-md-6">
	<?php $form = Activeform::begin();
	$listData = ['user'=>'user','reporter'=>'reporter','staff'=>'staff','admin'=>'admin','staffbkk'=>'staffbkk']; 
 	//$listData=ArrayHelper::map($countries,'code','name');
	?>
	<?= $form->field($model,'name_staff')->textInput(); ?>
	<?= $form->field($model,'email_staff')->input('email'); ?>

        <?=$form->field($model, 'unit')->textInput(array('class'=>'setlist'));  ?>
         <div class="col-md-6 setregdiv">
        <label> รูปแบบการส่ง</label>
        <?= Html::textInput('reg','',['class'=>'setreglist ']);?>
        </div>

     
	<?= $form->field($model, 'level_staff')->dropDownList($listData, ['prompt'=>'Choose...']); ?>
	<button type="submit" class="btn-info btn">submit</button>
	<?php activeForm::end();?>
</div>
 <?

$js_1 = "setTimeout(function(){
            
            controlunit1.removeOption(0)
            controlunit1 .setValue(".$model->unit.")
          $('.setregdiv').remove()

             },500) ";

$this->registerJs($js_1, View::POS_READY);?>