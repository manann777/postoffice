<?php
//namespace yii\base;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap\Alert;
//$this->registerJsFile('postoffice/web/js/send_form.js',['depends' => [\yii\web\JqueryAsset::className()]]);


if(Yii::$app->session->hasFlash('warningx')){
   echo Alert::widget([
    'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('warningx'), 'body'),
    'options'=>['class'=>'alert-danger']
    ]);
}


?>


<div class="senditem-_form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
        <?= $form->field($model, 'name_sender') ?>
        </div><div class="col-md-6">
        <?=$form->field($model, 'id_unit_sender')->textInput(array('class'=>'setlist'));  ?>
        </div><div class="col-md-6">
        <?= $form->field($model, 'name_receiver') ?>
        </div><div class="col-md-6">
        <?= $form->field($model, 'id_reg_type')->textInput(array('class'=>'setreglist')); ?>
        </div>
         <div class="col-md-6 qtyblock">
        <?= $form->field($model, 'qty_item')->textInput(['value'=>($model->isNewRecord?'1':$model->qty_item),'class'=>'qty form-control']); ?>
        </div>

        <div class="col-md-6 destiny_code">
        <?= $form->field($model, 'destiny_code')->textInput(['class'=>'code form-control']); ?>
        </div>

        <div class="col-md-6 id_reg_code">
        <?= $form->field($model, 'id_reg_item')->textInput(['class'=>'form-control id_reg_code_set']); ?>
        </div>

        <div class="col-md-6">
        <?= $form->field($model, 'item_comment') ?>
        </div>
        <div class="col-md-6">
            <label class="control-label" >&nbsp;</label>
        <div class="col-md-12">
       <div class="form-group col-md-5">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
        
        </div>
         <div class="form-group col-md-5"><?= Html::resetButton('Reset', ['class' => 'btn btn-warning btn-block'])?></div>
        
        </div>
    </div>
      

    <?php ActiveForm::end(); ?>

</div><!-- senditem-_form -->
<?php 
    
    $js_bkk = "setTimeout(function(){
            controlreg.removeOption(8);
          
             },500) ";

    $this->registerJs($js_bkk, View::POS_READY);



    if($model->id_reg_type){
        
       $js = "setTimeout(function(){
            controlreg.setValue(".$model->id_reg_type.")
           controlunit1.setValue(".$model->id_unit_sender.")
           $('.qty').val(".$model->qty_item.")

             },500) ";
           
        $this->registerJs($js, View::POS_READY);
    }
    if(isset($setoff)){
        if($setoff[0]){
            $js_1 = "setTimeout(function(){
            var setoff = [".$setoff[0].",".$setoff[1]."]
          
            $.each(setoff,function(index,value){
            controlreg.removeOption(value)
            })

            },700)";

            $this->registerJs($js_1, View::POS_READY);
        }
    }


?>

