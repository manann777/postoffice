<?php
use yii\widgets\ActiveForm;

?>
<div class="col-md-6">
	<?php $form = Activeform::begin();?>
	<?= $form->field($model,'name_unit')->textInput(); ?>
	<?= $form->field($model,'unit_in')->checkbox(['value'=>1,'checked'=>($model->unit_in == '1'?'checked':'')]); ?>
	<?= $form->field($model,'comment')->textInput(); ?>
	
	<button type="submit" class="btn-info btn">submit</button>
	<?php activeForm::end();?>
</div>