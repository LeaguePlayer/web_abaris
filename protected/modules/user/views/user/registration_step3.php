<?php
$this->breadcrumbs = array(
    'Регистрация - Шаг 1'=>array('/user/registration'),
    'Шаг 2'=>array('/user/registration', 'step'=>2),
    'Шаг 3'
);
?>

<!-- begin step 3 -->
<div class="signup-step3">
    <div class="container <?php if (Yii::app()->request->isAjaxRequest) echo 'ajax-modal'; ?>">
        <h3>Регистрация</h3>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('class'=>'abaris-form')
        )); ?>

        <?php echo $form->hiddenField($model, 'verifyCode'); ?>
        <div class="steps">Шаг 3 из 3</div>
        <div class="sign-info">Вы можете привязать один или несколько автомобилей к аккаунту прямо сейчас или сделать это позже в личном кабинете.</div>
        <div class="features">
            <div class="row-fluid">
                <div class="span12 blue">Что мне это даст? <br></div>
            </div>
            <div class="row-fluid">
                <div class="span6 clearfix">
                    <span class="big-number blue">1</span>
                    Вы можете вести учет обслуживания Ваших автмобилей.
                </div>
                <div class="span6">
                    <span class="big-number blue">2</span>
                    Записываться на СТО не выходя из дома, не заполняя лишних полей.
                </div>
            </div>
        </div>
        <div class="auto-items">
            <?php $counter = 1; ?>
            <?php foreach ( $userCars as $userCar ): ?>
                <div class="auto-item">
                    <div class="row-fluid">
                        <div class="span5"><?php echo $form->labelEx($userCar, 'brand', array('for'=>'UserCars_brand-'.$counter)); ?></div>
                        <div class="span7">
                            <?php echo $form->textField($userCar, 'brand', array('id'=>'UserCars_brand-'.$counter, 'class'=>'text-input', 'name'=>'UserCars['.$counter.'][brand]', 'data-attribute'=>'brand')); ?>
                            <?php echo $form->error($userCar, 'brand'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5"><?php echo $form->labelEx($userCar, 'model', array('for'=>'UserCars_model-'.$counter)); ?></div>
                        <div class="span7">
                            <?php echo $form->textField($userCar, 'model', array('id'=>'UserCars_model-'.$counter, 'class'=>'text-input', 'name'=>'UserCars['.$counter.'][model]', 'data-attribute'=>'model')); ?>
                            <?php echo $form->error($userCar, 'model'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5"><?php echo $form->labelEx($userCar, 'year', array('for'=>'UserCars_year-'.$counter)); ?></div>
                        <div class="span7">
                            <?php echo $form->textField($userCar, 'year', array('id'=>'UserCars_year-'.$counter, 'class'=>'text-input', 'name'=>'UserCars['.$counter.'][year]', 'data-attribute'=>'year')); ?>
                            <?php echo $form->error($userCar, 'year'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5"><?php echo $form->labelEx($userCar, 'VIN', array('for'=>'UserCars_VIN-'.$counter)); ?></div>
                        <div class="span7">
                            <?php echo $form->textField($userCar, 'VIN', array('id'=>'UserCars_VIN-'.$counter, 'class'=>'text-input', 'name'=>'UserCars['.$counter.'][VIN]', 'data-attribute'=>'VIN')); ?>
                            <?php echo $form->error($userCar, 'VIN'); ?>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            <?php endforeach; ?>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <a href="#" class="add-auto"><span>+</span>Добавить еще один автомобиль</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <button type="submit" class="login-submit">Готово</button>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- end step 3 -->