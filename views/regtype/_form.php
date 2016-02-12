<?php
use yii\widgets\ActiveForm;

?>
<div class="col-md-6">
	<?php $form = Activeform::begin();?>
	<?= $form->field($model,'type_reg')->textInput(); ?>
	<?= $form->field($model,'comment')->textInput(); ?>
	<button type="submit" class="btn-info btn">submit</button>
	<?php activeForm::end();?>
</div>