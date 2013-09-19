<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'detail-category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->dropDownListControlGroup($model,'parent_id', DetailCategory::getRootCategories(), array('class'=>'span8', 'empty'=>'Нет')); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/detailcategory/list')); ?>
	</div>

<?php $this->endWidget(); ?>
