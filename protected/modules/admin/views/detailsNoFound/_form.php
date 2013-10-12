<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'details-no-found-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'username',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->textFieldControlGroup($model,'mail',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->textFieldControlGroup($model,'article',array('class'=>'span8','maxlength'=>50)); ?>

	<?php echo $form->textFieldControlGroup($model,'date_find',array('class'=>'span8')); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/detailsnofound/list')); ?>
	</div>

<?php $this->endWidget(); ?>
