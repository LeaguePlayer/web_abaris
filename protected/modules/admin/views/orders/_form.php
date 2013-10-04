<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'orders-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'SID',array('class'=>'span8','maxlength'=>20)); ?>

	<?php echo $form->textFieldControlGroup($model,'paytype',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'order_status',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'cart_id',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'recipient_firstname',array('class'=>'span8','maxlength'=>45)); ?>

	<?php echo $form->textFieldControlGroup($model,'recipient_family',array('class'=>'span8','maxlength'=>45)); ?>

	<?php echo $form->textFieldControlGroup($model,'recipient_lastname',array('class'=>'span8','maxlength'=>45)); ?>

	<?php echo $form->textAreaControlGroup($model,'client_comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'client_email',array('class'=>'span8','maxlength'=>100)); ?>

	<?php echo $form->textFieldControlGroup($model,'client_phone',array('class'=>'span8','maxlength'=>20)); ?>

	<?php echo $form->textFieldControlGroup($model,'order_date',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'delivery_date',array('class'=>'span8')); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Orders::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/orders/list')); ?>
	</div>

<?php $this->endWidget(); ?>
