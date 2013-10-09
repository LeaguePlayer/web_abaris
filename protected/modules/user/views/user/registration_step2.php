<?php
$this->breadcrumbs = array(
    'Регистрация - Шаг 1'=>array('/user/registration'),
    'Шаг 2',
);
?>

<!-- begin step 2 -->
<div class="signup-step2">
    <div class="container <?php if (Yii::app()->request->isAjaxRequest) echo 'ajax-modal'; ?>">
        <h3>Регистрация</h3>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('class'=>'abaris-form')
        )); ?>
            <div class="steps">Шаг 2 из 3</div>
            <div class="sms-info">На указанный номер было выслано sms с кодом подтверждения, введите код в поле внизу.</div>
            <div class="row-fluid">
                <div class="span7">
                    <?php echo $form->textField($model, 'verifyCode', array('class'=>'text-input')); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
                <div class="span5">
                    <button type="submit" name="UpdateSmsCode" value="1" class="red-button repeat-sms">Повторно выслать код</button>
                </div>
            </div><br>
            <div class="row-fluid">
                <div class="span6"><a class="prev-step" href="<?php echo $this->createUrl('/user/registration'); ?>">Вернуться <i></i></a></div>
                <div class="span6"><button type="submit" class="next-step">Продолжить <i></i></button></div>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- end step 2 -->