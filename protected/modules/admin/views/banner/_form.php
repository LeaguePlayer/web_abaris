<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'banner-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'img_photo'); ?>
		<?php echo $form->fileField($model,'img_photo', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($model->img_photo) ) echo TbHtml::imageRounded( $model->imgBehaviorPhoto->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Banner' data-attributename='Photo' <?php if(empty($model->img_photo)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($model, 'img_photo'); ?>
	</div>

    <?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->textFieldControlGroup($model,'url',array('class'=>'span8','maxlength'=>255)); ?>

    <?php echo $form->dropDownListControlGroup($model, 'target', Banner::constants('target'), array(
        'class'=>'span8',
        'displaySize'=>1,
    )); ?>

	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Banner::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/banner/list')); ?>
	</div>

<?php $this->endWidget(); ?>
