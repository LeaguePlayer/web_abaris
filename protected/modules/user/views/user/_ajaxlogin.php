<div class="ajax-modal login-form">
    <h3>Вход</h3>
    <div class="stretch"></div>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('class'=>'login abaris-form')
    )); ?>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'username'); ?></div>
            <div class="span8">
                <?php echo $form->textField($model, 'username', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><label><?php echo $form->labelEx($model, 'password'); ?></label></div>
            <div class="span8">
                <?php echo $form->passwordField($model, 'password', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"></div>
            <div class="span8">
                <?php echo $form->checkBox($model, 'rememberMe', array('class'=>'css-checkbox')); ?>
                <?php echo $form->labelEx($model, 'rememberMe', array('class'=>'css-label')); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><a class="lock" href="<?php echo $this->createUrl('/user/recovery'); ?>">Забыли пароль?</a></div>
            <div class="span8">
                <a class="fancybox.ajax registrationButton" href="<?php echo $this->createUrl('/user/registration'); ?>">Зарегистироваться</a>
            </div>
        </div>
        <div class="row-fluid">
            <input type="submit" class="login-submit" value="Войти"/>
        </div>
    <?php $this->endWidget(); ?>
</div>