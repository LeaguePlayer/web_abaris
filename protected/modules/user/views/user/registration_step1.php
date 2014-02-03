<?php
$this->breadcrumbs = array(
    'Регистрация - Шаг 1',
);
?>


<!-- begin step 1 -->
<div class="signup-step1">
    <div class="container <?php if ( Yii::app()->request->isAjaxRequest ) echo 'ajax-modal'; ?>">
        <h3>Регистрация</h3>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('class'=>'abaris-form')
        )); ?>
        <div class="steps">Шаг 1 из 3</div>
        <div class="row-fluid">
            <div class="span12 type">
                <?php echo $form->radioButtonList($model, 'user_type', User::getUserTypes(), array(
                    'class'=>'css-checkbox choose_usertype', 'labelOptions'=>array('class'=>'css-label'),
                )); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($profile, 'first_name'); ?></div>
            <div class="span7">
                <?php echo $form->textField($profile, 'first_name', array('class'=>'text-input')); ?>
                <?php echo $form->error($profile, 'first_name'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($profile, 'last_name'); ?></div>
            <div class="span7">
                <?php echo $form->textField($profile, 'last_name', array('class'=>'text-input')); ?>
                <?php echo $form->error($profile, 'last_name'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($profile, 'father_name'); ?></div>
            <div class="span7">
                <?php echo $form->textField($profile, 'father_name', array('class'=>'text-input')); ?>
                <?php echo $form->error($profile, 'father_name'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'email'); ?></div>
            <div class="span7">
                <?php echo $form->textField($model, 'email', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($profile, 'phone'); ?></div>
            <div class="span7">
                <?php echo $form->textField($profile, 'phone', array('class'=>'text-input')); ?>
                <?php echo $form->error($profile, 'phone'); ?>
                <div class="info">На указанный номер будет отправлено sms с кодом подтвержения</div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'password'); ?></div>
            <div class="span7">
                <?php echo $form->passwordField($model, 'password', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'verifyPassword'); ?></div>
            <div class="span7">
                <?php echo $form->passwordField($model, 'verifyPassword', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'verifyPassword'); ?>
            </div>
        </div>

        <!--organization-->
        <div class="organization<?php if ( $model->isPhysic() ) echo " hidden"; ?>">

            <?php
            $profileFields=Profile::getFields();
            if ($profileFields) {
                foreach($profileFields as $field) {
                    if ( in_array($field->varname, array('phone', 'first_name', 'last_name', 'father_name')) )
                        continue;
                    ?>
                    <div class="row-fluid">
                        <div class="span5"><?php echo $form->labelEx($profile,$field->varname); ?></div>
                        <div class="span7">
                            <?php
                            if ($widgetEdit = $field->widgetEdit($profile)) {
                                echo $widgetEdit;
                            } elseif ($field->range) {
                                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range), array('class'=>'text-input'));
                            } elseif ($field->field_type=="TEXT") {
                                echo$form->textArea($profile,$field->varname,array('class'=>'text-input'));
                            } else {
                                echo $form->textField($profile,$field->varname,array('class'=>'text-input', 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                            }
                            ?>
                            <?php echo $form->error($profile, $field->varname); ?>
                        </div>
                    </div>
                <?php
                }
            }
            ?>

        </div>
        <div class="row-fluid req-info">
            <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
        </div>
        <div class="garant">
            Сайт гарантирует безопасность введенных личных данных
        </div>
        <div class="row-fluid">
            <div class="span6"><a class="cancel-signup" href="<?php echo Yii::app()->user->returnUrl; ?>">Я передумал регестрироваться</a></div>
            <div class="span6"><button class="next-step">Продолжить <i></i></button></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- end step 1 -->