<?php
$this->breadcrumbs = array(
    'Напишите нам',
);
?>


<!-- begin step 1 -->
<div class="signup-step1">
    <div class="container <?php if ( Yii::app()->request->isAjaxRequest ) echo 'ajax-modal'; ?>">
        <h3>Напишите нам</h3>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('class'=>'abaris-form')
        )); ?>
        
        
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'username'); ?></div>
            <div class="span7"><?php echo $form->textField($model, 'username', array('class'=>'text-input')); ?></div>
        </div>
        
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'email'); ?></div>
            <div class="span7">
                <?php echo $form->textField($model, 'email', array('class'=>'text-input')); ?>
                <div class="info">Если Вы хотите получить ответ на Ваше сообщение, укажите email</div>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'message'); ?></div>
            <div class="span7"><?php echo $form->textArea($model, 'message', array('class'=>'text-input area')); ?></div>
        </div>

        <div class="row-fluid req-info">
            <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
        </div>
        <div class="garant">
            Сайт гарантирует безопасность введенных данных
        </div>
        <div class="row-fluid">
            <div class="span6"><a class="cancel-signup" href="/">Вернуться на главную</a></div>
            <div class="span6"><button class="next-step b-button-blue">Продолжить <i></i></button></div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- end step 1 -->