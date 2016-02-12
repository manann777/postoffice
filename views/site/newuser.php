<? 
    use app\assets\AppAsset;
    AppAsset::register($this);
    use yii\web\View;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
   // use kartik\widgets\Select2;
 ?>
<div class="senditem-_form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
        <?= $form->field($model, 'name_staff')->textInput(['readonly'=>'readonly']) ?>
        </div><div class="col-md-6">
        <?=$form->field($model, 'unit')->textInput(array('class'=>'setlist'));  ?>
        </div><div class="col-md-6">
        <?= $form->field($model, 'email_staff')->textInput(['readonly'=>'readonly']) ?>
        </div>
        <div class="col-md-6 setregdiv">
        <label> รูปแบบการส่ง</label>
        <?= Html::textInput('reg','',['class'=>'setreglist ']);?>
        </div>

       

        

        <div class="col-md-6">
        <?= $form->field($model, 'comment') ?>
        </div>
        <div class="col-md-6">
            <label class="control-label" >&nbsp;</label>
        <div class="col-md-12">
       <div class="form-group col-md-5">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
        
        </div>
       
        
        </div>
    </div>
      

    <?php ActiveForm::end(); ?>
    <?

$js_1 = "setTimeout(function(){
            
            controlunit1.removeOption(0)
          $('.setregdiv').remove()

             },500) ";

$this->registerJs($js_1, View::POS_READY);?>