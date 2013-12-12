

<?php
$this->menu=array(
    array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Загрузка прайса для <?php echo $provider->name ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'providers-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <?php if ( Yii::app()->user->hasFlash('success_parse') ): ?>
        <div class="successMessage"><?php echo Yii::app()->user->getFlash('success_parse') ?></div>
    <?php endif ?>

    <?php echo $form->textFieldControlGroup($provider,'name_excel_column',array('class'=>'span3')); ?>

    <?php echo $form->textFieldControlGroup($provider,'producer_excel_column',array('class'=>'span3')); ?>

    <?php echo $form->textFieldControlGroup($provider,'article_excel_column',array('class'=>'span3')); ?>

    <?php echo $form->textFieldControlGroup($provider,'price_excel_column',array('class'=>'span3')); ?>

    <?php echo $form->textFieldControlGroup($provider,'instock_excel_column',array('class'=>'span3')); ?>

    <?php echo $form->textFieldControlGroup($provider,'start_row',array('class'=>'span3')); ?>

    <?php echo $form->fileFieldControlGroup($provider,'priceFile',array('class'=>'span5')); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton('Начать загрузку', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/providers/list')); ?>
    </div>

<?php $this->endWidget(); ?>