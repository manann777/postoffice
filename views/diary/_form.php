<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
  use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DiaryTb */
/* @var $form ActiveForm */
$this->title = 'GAD POSTOFFICE::บันทึกประจำวัน';
?>
<div class="col-md-12">
  <div class="col-md-6">
  <h4>ลงบันทึกประจำวันที่ <?=$model->diary_date?></h4>
  </div>
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
        window.location.replace('?r=diary/form&datetoday='+date)
         }",
        ]
    ]);
?>

  </div>
</div>
<div class="diary-_form">

    <?php $form = ActiveForm::begin(); ?>

       <div class="col-md-6"> <?= $form->field($model, 'receive_airmail') ?></div>
       <div class="col-md-3"> <?= $form->field($model, 'send_airmail')->textInput(['readonly' => true,'value'=>$air]) ?></div>
       <div class="col-md-3"> <?= $form->field($model, 'price_airmail')->textInput(['readonly' => true,'value'=>$airsum]) ?></div>

        <!-- <div class="col-md-6"> <?= $form->field($model, 'receive_ems')?></div> -->
       
       

       <div class="col-md-6"> <?= $form->field($model, 'receive_mailreg') ?></div>
       <div class="col-md-6"> <?= $form->field($model, 'send_ems')->textInput(['readonly' => true,'value'=>$ems]) ?></div>
       <div class="col-md-6"> <?= $form->field($model, 'receive_mail') ?></div>
       <div class="col-md-6"> <?= $form->field($model, 'send_mailreg')->textInput(['readonly' => true,'value'=>$reg]) ?></div>

       <div class="col-md-3"><?= $form->field($model, 'sendback_post') ?></div>
        <div class="col-md-3"><?= $form->field($model, 'sendback_postman') ?></div>

       <div class="col-md-3"> <?= $form->field($model, 'send_mail')->textInput(['readonly' => true,'value'=>$mansum]) ?></div>
       <div class="col-md-3"> <?= $form->field($model, 'mail_price')->textInput(['readonly' => true,'value'=>$pricemansum]) ?></div> 
       
       
        
       <div class="col-md-3"> <?= $form->field($model, 'return_post') ?></div>
       <div class="col-md-3"> <?= $form->field($model, 'return_postman') ?></div>
       
       <div class="col-md-6"> <?= $form->field($model, 'diary_date')->textInput(['readonly' => !$model->isNewRecord]) ?></div>
       <div class="col-md-6"> <?= $form->field($model, 'comment') ?></div>
       <div class="col-md-6"> <?= $form->field($model, 'writer')->textInput(['readonly'=>true,'value'=>$email]) ?></div>
    
        <div class="form-group col-md-4">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- diary-_form -->
