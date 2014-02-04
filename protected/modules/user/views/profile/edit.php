<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
/*$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);*/
?>

<?php
$this->breadcrumbs = array(
    'Личный кабинет - Редактирование профиля',
);
?>

<?php echo $this->renderPartial('/cabinet/_cabinet_steps'); ?>
<? /*<h1><?php echo UserModule::t('Edit profile'); ?></h1>*/?>
<!-- begin list-->
<div class="container abaris-form">
    <div class="row">
        <div class="span6">
        	<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
			<div class="successMessage">
			<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
			</div>
			<?php endif; ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'profile-form',
				'enableAjaxValidation'=>false,
				'htmlOptions' => array('enctype'=>'multipart/form-data'),
			)); ?>
                <div class="row-fluid">
                    <div class="span12 type">
                        <?php echo $form->radioButtonList($model, 'user_type', User::getUserTypes(), array(
                            'class'=>'css-checkbox choose_usertype', 'labelOptions'=>array('class'=>'css-label'),
                        )); ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($profile,'first_name')?></div>
                    <div class="span8">
                        <?=$form->textField($profile, 'first_name',array('size'=>60, 'class' => 'text-input'));?>
                        <?=$form->error($profile,'first_name')?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($profile,'last_name')?></div>
                    <div class="span8">
                        <?=$form->textField($profile, 'last_name',array('size'=>60, 'class' => 'text-input'));?>
                        <?=$form->error($profile,'last_name')?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($profile,'father_name')?></div>
                    <div class="span8">
                        <?=$form->textField($profile, 'father_name',array('size'=>60, 'class' => 'text-input'));?>
                        <?=$form->error($profile,'father_name')?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($model,'email')?></div>
                    <div class="span8">
                        <?=$form->textField($model, 'email',array('class' => 'text-input'));?>
                        <?=$form->error($model,'email')?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($profile,'phone')?></div>
                    <div class="span8">
                        <?php
							$this->widget('CMaskedTextField', array(
							'model' => $profile,
							'attribute' => 'phone',
							'mask' => '+7 (ddd)-ddd-dd-dd',
							'htmlOptions' => array('size' => 10, 'class' => 'text-input')));
						?>
                        <?=$form->error($profile,'phone')?>
                    </div>
                </div>

                <?/*
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($model,'verifyPassword')?></div>
                    <div class="span8">
                        <?=$form->passwordField($model, 'verifyPassword',array('class' => 'text-input'));?>
                        <?=$form->error($model,'verifyPassword')?>
                    </div>
                </div>
                */?>
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
                                <div class="span4"><?php echo $form->labelEx($profile,$field->varname); ?></div>
                                <div class="span8">
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
                <div class="row-fluid">
                	<?php echo CHtml::submitButton('Сохранить', array('class'=>'login-submit')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<!-- end list -->