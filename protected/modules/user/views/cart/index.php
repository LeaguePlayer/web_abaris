<!-- begin order steps  (step 1)-->
<div id="cart-wrap">
    <div class="container page-title">
        <h2 class="georgia">Корзина №<?php echo Yii::app()->user->dbCart->id ?></h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>
    <?php if ( $cartDataProvider->totalItemCount > 0 ): ?>
        <form method="POST" action="">
            <div class="catalog-container grid-items">
                <div class="catalog-grid">
                    <div class="catalog-grid-header scroll-fixed">
                        <div class="container">
                            <div class="row-fluid">
                                <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                                <div class="field span6"><div class="valign-text"><p>Название</p></div></div>
                                <div class="field span2"><div class="valign-text"><p>Количество</p></div></div>
                                <div class="field span2"><div class="valign-text"><p>Цена<br>скидка<br>со скидкой</p></div></div>
                                <div class="field span1"><div class="valign-text"><p>Срок доставки</p></div></div>
                            </div>
                        </div>
                    </div>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'id'=>'cart-details-list',
                        'template'=>'{items}',
                        'dataProvider'=>$cartDataProvider,
                        'itemView'=>'_cart_item',
                        'viewData'=>array('userDiscount'=>$userDiscount),
                        'emptyTagName'=>'div',
                        'emptyText'=>'Корзина пуста',
                        'updateSelector'=>'.catalog-pager a',
                    )); ?>

                </div>
            </div>
            <div class="subtotal icons">
                <div class="container">
                    <div class="span1 item total-select">
                        <span class="icon cart-icon select-icon"></span>
                        <span class="text">Выделен (<span class="selected_count">0</span>)</span>
                    </div>
                    <button class="span1 item active" name="CartItems[action]" value="archive">
                        <span class="icon cart-icon hold-icon"></span>
                        <span class="text">Отложить (<span class="selected_count">0</span>)</span>
                    </button>
                    <button class="span1 item archive" name="CartItems[action]" value="active">
                        <span class="icon cart-icon acivate-icon"></span>
                        <span class="text">В корзину (<span class="selected_count">0</span>)</span>
                    </button>
                    <button class="span1 item delete" type="submit" name="CartItems[action]" value="delete">
                        <span class="icon cart-icon delete-icon"></span>
                        <span class="text">Удалить (<span class="selected_count">0</span>)</span>
                    </button>
                    <div class="span3"></div>
                    <div class="span1 item transport">
                        <span class="icon"></span>
                        <span class="text">
                            <?= CHtml::activeCheckBox($cart, 'self_transport') ?>
                            <?= CHtml::activeLabelEx($cart, 'self_transport') ?>
                        </span>
                    </div>
                    <div class="span2 item">
                        <?php
                            $cost = Yii::app()->cart->getCost();
                            $dbCart = Yii::app()->user->getDbCart();
                            $deliveryCost = $dbCart->getDeliveryPrice($cost);
                        ?>
                        <span class="georgia summ">
                            <span class="number"><?=SiteHelper::priceFormat($cost + $deliveryCost);?></span> р.
                        </span>
                        <span class="text">Итого<? if ( !$dbCart->self_transport ) echo " (доставка +".SiteHelper::priceFormat( $deliveryCost )." р.)" ?></span>
                    </div>
                    <a href="<?=$this->createUrl('/orders/create')?>" class="span1 item pay"><span class="icon cart-icon pay-icon"></span><span class="text">Оплатить</span></a>
                </div>
            </div>
        </form>
        <div class="container info">
            <div class="span12 right">* Чтобы пропустить шаги оформления заказа можете заказать выбранный товар по телефон 8 (999) 464- 456- 998, назвав номер корзины</div>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="empty">Корзина пуста</div>
        </div>
    <?php endif; ?>
    <div class="container dop-info abacus">
        <div class="abacus"></div>
        <a href="<?php echo $this->createUrl('/pages/view', array('id'=>'usloviya_dostavki')) ?>">Ознакомиться с условиями доставки и возврата</a>
    </div>
    <div class="container dop-info abacus">
        <div class="cog"></div>
        <a href="<?php echo $this->createUrl('/pages/view', array('id'=>'stantsiya_tehnicheskogo_obslujivaniya')) ?>">Запись на станцию технического обслуживания</a>
        <span>У нашей компании есть сеть СТО, на которые Вы можете записаться в удобное время и пройти техническое обслуживание</span>
    </div>
</div>
<!-- end oreder steps -->