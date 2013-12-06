<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'details-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>



    <div class='control-group'>
        <?php echo CHtml::activeLabelEx($model, 'img_photo'); ?>
        <?php echo $form->fileField($model,'img_photo', array('class'=>'span3')); ?>
        <div class='img_preview'>
            <?php if ( !empty($model->img_photo) ) echo TbHtml::imageRounded( $model->imgBehaviorPhoto->getImageUrl('small') ) ; ?>
            <span class='deletePhoto btn btn-danger btn-mini' data-modelname='Details' data-attributename='Photo' <?php if(empty($model->img_photo)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
        </div>
        <?php echo $form->error($model, 'img_photo'); ?>
    </div>



	<?php echo $form->textFieldControlGroup($model,'article',array('class'=>'span8','maxlength'=>45)); ?>



	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span8','maxlength'=>256)); ?>



    <?php echo $form->dropDownListControlGroup($model, 'brand_id',
        CHtml::listData(Brands::model()->findAll(array('order'=>'name')), 'id', 'name'),
        array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Не выбран')); ?>



	<?php echo $form->textFieldControlGroup($model,'price',array('class'=>'span8')); ?>



    <?php echo $form->dropDownListControlGroup($model, 'category_id',
        CHtml::listData(DetailCategory::model()->findAll(array('order'=>'name')), 'id', 'name'),
        array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Не выбрана')); ?>



	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'wswg_description'); ?>
		<?php $this->widget('appext.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'wswg_description',
		)); ?>
		<?php echo $form->error($model, 'wswg_description'); ?>
	</div>



    <div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/details/list')); ?>
	</div>

<?php $this->endWidget(); ?>
