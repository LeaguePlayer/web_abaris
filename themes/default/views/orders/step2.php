<?php
$this->breadcrumbs = array(
    'Корзина'=>array('/user/cart'),
    'Оформление заказа - Шаг 1'=>array('/orders/create'),
);
?>

<!-- begin order steps  (step 2)-->
<div class="container order page-title">
    <h2 class="georgia">Оформление заказа</h2>
    <div>
        <span class="blue-line"></span>
        <span class="steps">Шаг <span>2</span> из 3</span>
    </div>
    <div class="step-type georgia">Информация о заказе</div>
</div>
<div class="subtotal">
    <div class="container">
        <?php
        $count = Yii::app()->cart->getCount();
        $user = Yii::app()->user->model();
        $userDiscount = $user !== null ? ($user->discount) ? $user->discount : '0' : '0';
        ?>
        <div class="span1"><span class="georgia"><?php echo SiteHelper::priceFormat($count); ?></span> <?php echo SiteHelper::pluralize($count, array('Товар', 'Товара', 'Товаров')) ?></div>
        <div class="span1"><span class="georgia"><?php echo $userDiscount; ?></span> Скидка</div>
        <div class="span2"><span class="georgia"><?php echo SiteHelper::priceFormat(Yii::app()->cart->getCost(true)); ?> р.</span> Итого</div>
    </div>
</div>

<div class="order container page-title" style="margin-top: 40px; margin-bottom: 20px;">
    <h2 class="georgia">Получатель</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>

<div class="order container order-step2">
<?php $form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('id'=>'order-form-step2', 'class'=>'abaris-form')
)); ?>
    <?php echo $form->hiddenField($model, 'paytype'); ?>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'recipient_family'); ?></div>
        <div class="span4"><?php echo $form->textField($model, 'recipient_family', array('class'=>'text-input')); ?></div>
    </div>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'recipient_firstname'); ?></div>
        <div class="span4"><?php echo $form->textField($model, 'recipient_firstname', array('class'=>'text-input')); ?></div>
    </div>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'recipient_lastname'); ?></div>
        <div class="span4"><?php echo $form->textField($model, 'recipient_lastname', array('class'=>'text-input')); ?></div>
    </div>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'client_email'); ?></div>
        <div class="span4"><?php echo $form->textField($model, 'client_email', array('class'=>'text-input')); ?></div>
    </div>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'client_phone'); ?></div>
        <div class="span4"><?php echo $form->textField($model, 'client_phone', array('class'=>'text-input')); ?></div>
        <div class="span4 tt">
            <a class="information" data-toggle="tooltip" data-placement="top" data-original-title="Укажите Ваш номер телефона, чтобы мы могли сообщить Вам, когда придет заказ "><img src="<?php echo $this->getAssetsUrl('application'); ?>/img/tooltip.gif" alt=""></a>
        </div>
    </div>
    <div class="row">
        <div class="span2"><?php echo CHtml::activeLabelEx($model, 'client_comment'); ?></div>
        <div class="span4"><?php echo $form->textArea($model, 'client_comment', array('class'=>'text-input', 'rows'=>10)); ?></div>
    </div>
    <div class="row req-info offset">
        <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
    </div>
    <div class="row offset">
        <div class="span12">Адрес магазина:  <span class="grey"><?php echo Settings::model()->getOption('address'); ?></span></div>
    </div>
    <div class="row offset">
        <div class="span12">
            <?php echo AbarisHtml::activeCheckBox($model, 'preffered', array('class'=>'css-checkbox')); ?>
            <?php echo CHtml::activeLabelEx($model, 'preffered', array('class'=>'css-label')); ?>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="span12 garant">Мы гарантируем безопасность введенных на сайте данных</div>
    </div>
    <div class="row">
        <div class="span4"><a href="<?php echo $this->createUrl('/orders/create'); ?>" class="prev-step">Верунться к шагу 1<i></i></a></div>
        <div class="span4"><button type="submit" class="next-step">Продолжить<i></i></button></div>
    </div>
    <div class="row">
        <div class="span12 call grey">Заказ по телефону <?php echo Settings::model()->getOption('order_phone'); ?>, назвав номер корзины <span><?php echo Yii::app()->user->dbCart->id; ?></span></div>
    </div>
<?php $this->endWidget(); ?>
</div>
<!-- end oreder steps -->