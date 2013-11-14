<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'providers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->textFieldControlGroup($model,'day_count',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'name_excel_column',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'producer_excel_column',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'article_excel_column',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'price_excel_column',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'instock_excel_column',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($model,'start_row',array('class'=>'span8')); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/providers/list')); ?>
	</div>

<?php $this->endWidget(); ?>
