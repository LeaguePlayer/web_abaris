<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'brands-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'alias',array('class'=>'span8','maxlength'=>45)); ?>

	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>45)); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'img_logo'); ?>
		<?php echo $form->fileField($model,'img_logo', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($model->img_logo) ) echo TbHtml::imageRounded( $model->imgBehaviorLogo->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Brands' data-attributename='Logo' <?php if(empty($model->img_logo)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($model, 'img_logo'); ?>
	</div>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'wswg_description'); ?>
		<?php $this->widget('appext.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'wswg_description',
		)); ?>
		<?php echo $form->error($model, 'wswg_description'); ?>
	</div>

	<?php echo $form->dropDownListControlGroup($model, 'status', Brands::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/brands/list')); ?>
	</div>

<?php $this->endWidget(); ?>
