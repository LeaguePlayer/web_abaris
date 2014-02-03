<?php
    $this->breadcrumbs = array(
        'Корзина'=>array('/user/cart'),
        'Оформление заказа'
    );
?>

<!-- begin order steps  (step 1)-->
<div class="container order page-title">
    <h2 class="georgia">Оформление заказа</h2>
    <div>
        <span class="blue-line"></span>
        <span class="steps">Шаг <span>1</span> из 3</span>
    </div>
    <div class="step-type georgia">Способ оплаты</div>
</div>
<div class="subtotal">
    <div class="container">
        <?php
            $dbCart = Yii::app()->user->getDbCart();
            $cost = Yii::app()->cart->getCost(true);
            $deliveryCost = $dbCart->getDeliveryPrice($cost);
            $count = Yii::app()->cart->getCount();
            $user = Yii::app()->user->model();
            $userDiscount = $user !== null ? ($user->discount) ? $user->discount : '0' : '0';
        ?>
        <div class="span1"><span class="georgia"><?php echo SiteHelper::priceFormat($count); ?></span> <?php echo SiteHelper::pluralize($count, array('Товар', 'Товара', 'Товаров')) ?></div>
        <div class="span1"><span class="georgia"><?php echo $userDiscount; ?></span> Скидка</div>
        <div class="span2"><span class="georgia"><?php echo SiteHelper::priceFormat($deliveryCost); ?> р.</span> Доставка</div>
        <div class="span2"><span class="georgia"><?php echo SiteHelper::priceFormat($cost + $deliveryCost); ?> р.</span> Итого</div>
    </div>
</div>

<div class="order container page-title" style="margin-top: 40px; margin-bottom: 20px;">
    <h2 class="georgia">Выберите способ оплаты</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>

<div class="order container order-step1">
<?php $form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'abaris-form')
)); ?>

    <?php $payTypes = Orders::getPaytypes(); ?>
    <div class="row">
        <div class="span4">Наличные</div>
        <div class="span4">
            <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('id'=>'radio_cash', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_CASH)); ?>
            <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_CASH], 'radio_cash', array('class'=>'css-label')); ?>
        </div>
    </div>
    <div class="row">
        <div class="span4">Банковские карты</div>
        <div class="span4">
            <div class="types">
                <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_visa', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_VISA)); ?>
                <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_VISA], 'radio_visa', array('class'=>'css-label')); ?>
                <br>
                <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_mastercard', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_MASTERCARD)); ?>
                <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_MASTERCARD], 'radio_mastercard', array('class'=>'css-label')); ?>
            </div>
            <div class="cards">
                <div class="visa card"></div>
                <div class="mastercard card"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span4">Электронные деньги</div>
        <div class="span4">
            <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_mail', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_MAIL)); ?>
            <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_MAIL], 'radio_mail', array('class'=>'css-label')); ?>
            <br>
            <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_yandex', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_YANDEX)); ?>
            <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_YANDEX], 'radio_yandex', array('class'=>'css-label')); ?>
            <br>
            <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_sberbank', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_SBERBANK)); ?>
            <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_SBERBANK], 'radio_sberbank', array('class'=>'css-label')); ?>
            <br>
            <?php echo AbarisHtml::activeRadioButton($model, 'paytype', array('disabled'=>'disabled', 'id'=>'radio_webmoney', 'class'=>'css-checkbox', 'value'=>Orders::PAYTYPE_WEBMONEY)); ?>
            <?php echo AbarisHtml::label($payTypes[Orders::PAYTYPE_WEBMONEY], 'radio_webmoney', array('class'=>'css-label')); ?>
        </div>
    </div>
    <div class="row">
        <div class="span12 grey">Предоплаченный заказ вручается лицу, указанному в качестве Получателя Заказа по документу, удостоверяющему личность.</div>
    </div>
    <div class="row">
        <div class="span4"><a href="<?php echo $this->createUrl('/user/cart'); ?>" class="prev-step">Верунться в корзину<i></i></a></div>
        <div class="span4"><button type="submit" class="next-step">Продолжить<i></i></button></div>
    </div>
    <div class="row">
        <div class="span12 garant">Мы гарантируем безопасность введенных на сайте данных</div>
    </div>
    <div class="row">
        <div class="span12 call grey">Заказ по телефону <?php echo Settings::model()->getOption('order_phone'); ?>, назвав номер корзины <span><?php echo Yii::app()->user->dbCart->id; ?></span></div>
    </div>
<?php $this->endWidget(); ?>
</div>
<!-- end oreder steps -->


<?php if ( !Yii::app()->user->getState('__remindSTO') ): ?>
    <div id="inline_logs">
        <div class="log_message">
            <?php
                $this->renderPartial('_remind_sto');
                Yii::app()->user->setState('__remindSTO', true);
            ?>
        </div>
    </div>
<?php endif; ?>