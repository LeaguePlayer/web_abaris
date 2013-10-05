<!-- login-->
<div class="container login">
    <div class="span5 page-title">
        <h2 class="georgia">Авторизуйтесь на сайте</h2>
        <div>
            <span class="blue-line"></span>
        </div>
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
                    <a href="<?php echo $this->createUrl('/user/registration'); ?>">Зарегистироваться</a>
                </div>
            </div>
            <div class="row-fluid">
                <input type="submit" class="login-submit" value="Войти"/>
            </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="span5 page-title">
        <h2 class="georgia">Новый пользователь на сайте?</h2>
        <div>
            <span class="blue-line"></span>
        </div>
        <p class="info">Нажмите кнопку ниже чтобы продолжить без регистрации</p>
        <a href="<?php echo Yii::app()->user->returnUrl; ?>" class="b-button b-button-blue">Продолжить как гость</a>
    </div>
</div>
<!-- login -->