<?php
$formLabel = ($model->isNewRecord) ? 'Добавление СТО' : 'Редактирование СТО';
$this->breadcrumbs = array(
    'Личный кабинет - Учет технического обслуживания' => array('/user/cabinet/sto'),
    $formLabel
);
?>



<div class="container <?php if (Yii::app()->request->isAjaxRequest) echo 'ajax-modal'; ?>">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'abaris-form')
    )); ?>
        <h3><?php echo $formLabel; ?></h3>
        <div class="stretch"></div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    $options = array(
                        "class" => "text-input",
                        'empty'=>'Выберите авто'
                    );
                if (!$model->isNewRecord)
                    $options['readonly'] = 'readonly';
                ?>
                <?php echo $form->dropDownList($model, "user_car_id", CHtml::ListData($userCars, "id", "model"), $options); ?>
                <?php echo $form->error($model, "user_car_id"); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'maintenance_name'); ?></div>
            <div class="span8">
                <?php echo $form->textField($model, 'maintenance_name', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'maintenance_name'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'maintenance_date'); ?></div>
            <div class="span8">
                <?php echo $form->textField($model, 'maintenance_date', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'maintenance_date'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'maintenance_type'); ?></div>
            <div class="span8">
                <?php echo $form->dropDownList($model, "maintenance_type", $model->getMaintenanceTypes(), array('class' => 'text-input')); ?>
                <?php echo $form->error($model, 'maintenance_type'); ?>
            </div>
        </div>
        <div class="sep"></div>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'maintenance_cost'); ?></div>
            <div class="span8">
                <?php echo $form->textField($model, "maintenance_cost", array('class' => 'text-input')); ?>
                <?php echo $form->error($model, 'maintenance_cost'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4"><?php echo $form->labelEx($model, 'azs_cost'); ?></div>
            <div class="span8">
                <?php echo $form->textField($model, "azs_cost", array('class' => 'text-input')); ?>
                <?php echo $form->error($model, 'azs_cost'); ?>
            </div>
        </div>
        <div class="sep"></div>
        <div class="row-fluid">
            <div class="span12">
                <input type="submit" name="submit" class="login-submit" value="Сохранить" />
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>
