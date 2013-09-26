<!-- begin order steps  (step 1)-->
<div class="container page-title">
    <h2 class="georgia">Корзина №1</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>
<form method="POST" action="">
<div class="catalog-container grid-items">
    <div class="catalog-grid">
        <div class="catalog-grid-header">
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
            'emptyText'=>'',
            'updateSelector'=>'.catalog-pager a',
        )); ?>

    </div>
</div>
<div class="subtotal icons">
    <div class="container">
        <div class="span1 item">
            <span class="icon cart-icon select-icon"></span>
            <span class="text">Выделен (<span class="selected_count">0</span>)</span>
        </div>
        <a href="#" class="span1 item">
            <span class="icon cart-icon hold-icon"></span>
            <span class="text">Отложить (<span class="selected_count">0</span>)</span>
        </a>
        <button class="span1 item" type="submit">
            <span class="icon cart-icon delete-icon"></span>
            <span class="text">Удалить (<span class="selected_count">0</span>)</span>
        </button>
        <div class="span5"></div>
        <div class="span2 item"><span class="georgia summ"><?php echo Yii::app()->cart->getCost(); ?> р.</span> Итого</div>
        <a href="#" class="span1"><div class="select cart-icon pay-icon"></div>Оплатить</a>
    </div>
</div>
</form>
<div class="container info">
    <div class="span12 right">* Чтобы пропустить шаги оформления заказа можете заказить выбранный товар по телефон 8 (999) 464- 456- 998, назвав номер корзины</div>
</div>
<div class="container dop-info abacus">
    <div class="abacus"></div>
    <a href="#">Ознакомиться с условиями доставки и возврата</a>
</div>
<div class="container dop-info abacus">
    <div class="cog"></div>
    <a href="#">Ознакомиться с условиями доставки и возврата</a>
    <span>У нашей компании есть сеть СТО, на которые Вы можете записаться в удобное время и пройти техническое обслуживание</span>
</div>
<!-- end oreder steps -->