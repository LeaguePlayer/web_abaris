<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'engines-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>100)); ?>

	<?php echo $form->textFieldControlGroup($model,'volume',array('class'=>'span8')); ?>

	<?php echo $form->dropDownListControlGroup($model,'fuel', Engines::getFuelTypes(), array(
        'class'=>'span8',
        'empty'=>'Не выбрано'
    )); ?>

	<?php echo $form->textFieldControlGroup($model,'power',array('class'=>'span8')); ?>

	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/engines/list')); ?>
	</div>

<?php $this->endWidget(); ?>
