<!-- begin order steps  (step 3)-->
<div class="container order page-title">
    <h2 class="georgia">Оформление заказа</h2>
    <div>
        <span class="blue-line"></span>
        <span class="steps">Шаг <span>3</span> из 3</span>
    </div>
    <div class="step-type georgia">Подтверждение заказа</div>
</div>
<div class="order container order-step3">
    <!-- <form class="abaris-form" action="" method="POST"> -->
    <div class="row">
        <div class="span12"><span class="black">Продавец</span>: Абарис, <?php echo ' '.Settings::getOption('address'); ?></div>
    </div>
    <div class="row clear">
        <div class="span12 black">Параметры доставки (<a href="<?php echo $this->createUrl('/orders/create', array('step'=>2)); ?>">изменить</a>): </div>
    </div>

    <div class="row clear">
        <div class="span2 black">Адрес:</div>
        <div class="span4">Абарис, <?php echo Settings::getOption('address'); ?></div>
    </div>
    <div class="row clear">
        <div class="span2 black">Получатель:</div>
        <div class="span4"><?php echo $model->recipientFio; ?></div>
    </div>
    <div class="row clear">
        <div class="span2 black">Телефон: </div>
        <div class="span4"><?php echo $model->client_phone; ?></div>
    </div>
    <div class="row">
        <div class="span2 black">E-mail:</div>
        <div class="span4"><?php echo $model->client_email; ?></div>
    </div>
    <div class="row">
        <div class="span12 black">Состав заказа (<a href="<?php echo $this->createUrl('/user/cart'); ?>">изменить</a>): </div>
    </div>
    <!-- </form> -->
</div>
<div class="catalog-container">
    <div class="catalog-grid">
        <div class="catalog-grid-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="field span2"><div class="valign-text"></div></div>
                    <div class="field span4"><div class="valign-text"><p>Название</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Количество</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Цена</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Скидка</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Цена со скидкой</p></div></div>
                </div>
            </div>
        </div>
        <?php
            $user = Yii::app()->user->model();
            $userDiscount = $user !== null ? $user->discount : 0;
        ?>
        <?php foreach ( Yii::app()->cart->getPositions() as $position ): ?>
        <?php if ($position->isArchived()) continue; ?>
        <div class="catalog-grid-row no-hover">
            <div class="container">
                <div class="row-fluid">
                    <div class="span2 field img"><?php echo $position->getImage('small'); ?></div>
                    <div class="span4 field left"><div class="valign-text">
                            <p><a href="#"><?php echo $position->name; ?></a><br>производитель <?php echo $position->brand->name; ?><br>код: <?php echo $position->article; ?></p>
                        </div></div>
                    <div class="span2 field"><div class="valign-text"><p><?php echo $position->getQuantity(); ?> шт</p></div></div>
                    <div class="span2 field"><div class="valign-text"><p><?php echo SiteHelper::priceFormat($position->getSumPrice(false)); ?> руб.</p></div></div>
                    <div class="span1 field"><div class="valign-text"><p><?php echo $position->discount + $userDiscount->discount; ?> %</p></div></div>
                    <div class="span1 field"><div class="valign-text"><p><?php echo SiteHelper::priceFormat($position->getSumPrice(true)); ?> руб.</p></div></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="subtotal">
    <div class="container">
        <div class="row">
            <div class="span8"></div>
            <div class="span2"><span class="georgia">Сегодня</span> Дата доставки</div>
            <div class="span2"><span class="georgia"><?=SiteHelper::priceFormat(Yii::app()->cart->getCost());?> р.</span> Итого</div>
        </div>
    </div>
</div>
<div class="order container order-step3">
    <form class="abaris-form" action="" method="POST">
        <div class="row">
            <div class="span12 black">Способ оплаты (<a href="<?php echo $this->createUrl('/orders/create'); ?>">изменить</a>):<br>
                <span class="grey"><?php echo Orders::getPaytypes($model->paytype); ?></span></div>
        </div>
        <div class="row">
            <div class="span12 garant">Мы гарантируем безопасность введенных на сайте данных</div>
        </div>
        <div class="row">
            <div class="span12 grey">
                <span>* Подтверждая заказ Вы обязуетесь оплатить и забрать товар</span><br>
                <div id="snake-element">
                    <?php echo AbarisHtml::activeCheckBox($model, 'confirm', array('class'=>'css-checkbox')); ?>
                    <?php echo CHtml::activeLabelEx($model, 'confirm', array('class'=>'css-label')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4"><a href="<?php echo $this->createUrl('/orders/create', array('step'=>2)); ?>" class="prev-step">Верунться к шагу 2<i></i></a></div>
            <div class="span4"><button disabled type="submit" class="next-step order-button finish">Подтвердить<i></i></button></div>
        </div>
    </form>
</div>
<!-- end oreder steps -->