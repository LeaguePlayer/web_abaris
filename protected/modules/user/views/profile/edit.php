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
<?php echo $this->renderPartial('/cabinet/_cabinet_steps'); ?>
<? /*<h1><?php echo UserModule::t('Edit profile'); ?></h1>*/?>
<!-- begin list-->
<div class="container">
    <div class="row">
        <div class="span6">
        	<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
			<div class="success">
			<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
			</div>
			<?php endif; ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'profile-form',
				'enableAjaxValidation'=>true,
				'htmlOptions' => array('enctype'=>'multipart/form-data', 'class' => 'abaris-form'),
			)); ?>
                <div class="row-fluid">
                    <div class="span12 type">
                        <input id="fiz" type="radio" name="type" checked class="css-checkbox">
                        <label for="fiz" name="demo_lbl_1" class="css-label">Частное лицо</label>
                        <br>
                        <input id="ur" type="radio" name="type" class="css-checkbox">
                        <label for="ur" name="demo_lbl_1" class="css-label">Юридическое</label>
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
							'mask' => '9999999999',
							'htmlOptions' => array('size' => 10, 'class' => 'text-input')));
						?>
                        <?=$form->error($profile,'phone')?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Привязанна дисконтная карта №</label></div>
                    <div class="span8">
                        <input class="text-input" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($model,'password')?></div>
                    <div class="span8">
                        <?=$form->passwordField($model, 'password',array('class' => 'text-input'));?>
                        <?=$form->error($model,'password')?>
                    </div>
                </div>
                <?/*
                <div class="row-fluid">
                    <div class="span4"><?=$form->labelEx($model,'verifyPassword')?></div>
                    <div class="span8">
                        <?=$form->passwordField($model, 'verifyPassword',array('class' => 'text-input'));?>
                        <?=$form->error($model,'verifyPassword')?>
                    </div>
                </div>*/?>
                <!--organization-->
                <div class="organization" style="display: none">
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'company_name')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'company_name',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'company_name')?>
	                    </div>
	                </div>
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'jur_name')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'jur_name',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'jur_name')?>
	                    </div>
	                </div>
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'director_fio')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'director_fio',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'director_fio')?>
	                    </div>
	                </div>
	                <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'INN')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'INN',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'INN')?>
	                    </div>
	                </div>
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'KPP')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'KPP',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'KPP')?>
	                    </div>
	                </div>
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'BIC')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'BIC',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'BIC')?>
	                    </div>
	                </div>
                    <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'account_number')?></div>
	                    <div class="span8">
	                        <?=$form->textField($profile, 'account_number',array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'account_number')?>
	                    </div>
	                </div>
	                <div class="row-fluid">
	                    <div class="span4"><?=$form->labelEx($profile,'taxation_system')?></div>
	                    <div class="span8">
	                        <?=$form->dropDownList($profile, 'taxation_system',array(),array('class' => 'text-input'));?>
	                        <?=$form->error($profile,'taxation_system')?>
	                    </div>
	                </div>
                </div>
                <div class="row-fluid req-info">
                    <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
                </div>
                <div class="row-fluid">
                	<?php echo CHtml::submitButton('Сохранить', array('class'=>'login-submit')); ?>
                </div>
                <?php /*
					$profileFields=Profile::getFields();
					if ($profileFields) {
						foreach($profileFields as $field) {
						?>
					<div class="row-fluid">
						<div class="span4"><?=$form->labelEx($profile,'INN')?></div>
						<div class="span8">
						<?php //echo $form->labelEx($profile,$field->varname);
						
						if ($widgetEdit = $field->widgetEdit($profile)) {
							echo $widgetEdit;
						} elseif ($field->range) {
							echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
						} elseif ($field->field_type=="TEXT") {
							echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class'=>'text-input'));
						} else {
							echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class' => 'text-input'));
						}
						echo $form->error($profile,$field->varname); ?>
						</div>
					</div>	
							<?php
							}
						}*/
				?>
				<?/*
                <div class="row-fluid">
                    <div class="span4"><label>Имя<span class="required">*</span></label></div>
                    <div class="span8">
                        <input class="text-input" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Фамилия<span class="required">*</span></label></div>
                    <div class="span8">
                        <input class="text-input" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>E-mail <span class="required">*</span></label></div>
                    <div class="span8">
                        <input class="text-input" type="email">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Номер телефона <span class="required">*</span></label></div>
                    <div class="span8">
                        <input class="text-input" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Привязанна дисконтная карта №</label></div>
                    <div class="span8">
                        <input class="text-input" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Пароль</label></div>
                    <div class="span8">
                        <input class="text-input" type="password">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4"><label>Новый пароль</label></div>
                    <div class="span8">
                        <input class="text-input" type="password">
                    </div>
                </div>
                <!--organization-->
                <div class="organization" style="display: none">
                    <div class="row-fluid">
                        <div class="span4"><label>Наименование организации</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>

                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>Наименование юр. лица</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>ФИО руководителя</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>КПП</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>БИК банка</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>№ расч. счета</label></div>
                        <div class="span8">
                            <input class="text-input" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4"><label>Система налогооблажения</label></div>
                        <div class="span8">
                            <select class="text-input">
                                <option>Общая</option>
                                <option>Общая</option>
                                <option>Общая</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-fluid req-info">
                    <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
                </div>
                <div class="row-fluid">
                    <div class="span12"><a class="login-submit" href="#">Сохранить</a></div>
                </div>
                */?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<!-- end list -->
<? /*
<div class="form">


	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

<?php 
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
		<?php echo $form->labelEx($profile,$field->varname);
		
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo $form->error($profile,$field->varname); ?>
	</div>	
			<?php
			}
		}
?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
	</div>



</div><!-- form -->
*/?>