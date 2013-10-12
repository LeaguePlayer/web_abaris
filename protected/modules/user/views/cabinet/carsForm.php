<?php
$formLabel = ($user_car->isNewRecord) ? 'Добавление нового автомобиля' : 'Редактирование автомобиля';
$this->breadcrumbs = array(
    'Личный кабинет - Управление автомобилями' => array('/user/cabinet'),
    $formLabel
);
?>

<?php if (Yii::app()->request->isAjaxRequest) echo CHtml::hiddenField('ajaxform', 1); ?>
<div class="container <?php if (Yii::app()->request->isAjaxRequest) echo 'ajax-modal'; ?>">
    <h3><?php echo $formLabel; ?></h3>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'abaris-form')
    )); ?>
        <div class="auto-items">
            <div class="auto-item">
                <div class="row-fluid">
                    <div class="span4">
                        <?php echo $form->labelEx($user_car,'brand'); ?>
                    </div>
                    <div class="span8">
                        <?php echo $form->textField($user_car, "brand", array("class" => "text-input")); ?>
                        <?php echo $form->error($user_car, "brand"); ?>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <?php echo $form->labelEx($user_car,'model'); ?>
                    </div>
                    <div class="span8">
                        <?php echo $form->textField($user_car, "model", array("class" => "text-input")); ?>
                        <?php echo $form->error($user_car, "model"); ?>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <?php echo $form->labelEx($user_car,'year'); ?>
                    </div>
                    <div class="span8">
                        <?php echo $form->textField($user_car, "year", array("class" => "text-input")); ?>
                        <?php echo $form->error($user_car, "year"); ?>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <?php echo $form->labelEx($user_car,'VIN'); ?>
                    </div>
                    <div class="span8">
                        <?php echo $form->textField($user_car, "VIN", array("class" => "text-input")); ?>
                        <?php echo $form->error($user_car, "VIN"); ?>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <?php echo $form->labelEx($user_car,'mileage'); ?>
                    </div>
                    <div class="span8">
                        <?php echo $form->textField($user_car, "mileage", array("class" => "text-input")); ?>
                        <?php echo $form->error($user_car, "mileage"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <input type="submit" name="submit" class="login-submit" value="Сохранить" />
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>
