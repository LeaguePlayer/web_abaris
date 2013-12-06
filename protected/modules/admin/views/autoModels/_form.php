<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'auto-models-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>100)); ?>

	<?php echo $form->dropDownListControlGroup($model,'brand_id', CHtml::listData(Brands::model()->findAll(), 'id', 'name'),array(
        'class'=>'span8',
        'empty'=>'Не выбрана',
    )); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'img_photo'); ?>
		<?php echo $form->fileField($model,'img_photo', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($model->img_photo) ) echo TbHtml::imageRounded( $model->imgBehaviorPhoto->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='AutoModels' data-attributename='Photo' <?php if(empty($model->img_photo)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($model, 'img_photo'); ?>
	</div>

	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'dt_release_date'); ?>
        <?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
            'model' => $model,
            'attribute' => 'dt_release_date',
            'pluginOptions' => array(
                'format' => 'dd-MM-yyyy',
                'language' => 'ru',
                'pickSeconds' => false,
                'pickTime' => false
            )
        )); ?>
        <?php echo $form->error($model, 'dt_release_date'); ?>
    </div>

    <div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'dt_end_release_date'); ?>
        <?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
            'model' => $model,
            'attribute' => 'dt_end_release_date',
            'pluginOptions' => array(
                'format' => 'dd-MM-yyyy',
                'language' => 'ru',
                'pickSeconds' => false,
                'pickTime' => false
            )
        )); ?>
        <?php echo $form->error($model, 'dt_end_release_date'); ?>
    </div>

	<?php echo $form->textFieldControlGroup($model,'number_doors',array('class'=>'span8')); ?>

    <?php echo $form->dropDownListControlGroup($model,'bodytype_id', CHtml::listData(Bodytypes::model()->findAll(), 'id', 'name'),array(
        'class'=>'span8',
        'empty'=>'Не выбран',
    )); ?>

	<?php echo $form->textFieldControlGroup($model,'VIN',array('class'=>'span8','maxlength'=>20)); ?>

    <div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/autoModels/list')); ?>
	</div>

<?php $this->endWidget(); ?>
