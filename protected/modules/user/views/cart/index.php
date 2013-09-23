<!-- begin order steps  (step 1)-->
<div class="container page-title">
    <h2 class="georgia">Корзина №1</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>
<div class="catalog-container grid-items">
    <div class="catalog-grid">
        <div class="catalog-grid-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                    <div class="field span7"><div class="valign-text"><p>Название</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Количество</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Цена<br>скидка<br>со скидкой</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Срок доставки</p></div></div>
                </div>
            </div>
        </div>
        <form action="" method="POST">
            <?php $this->widget('zii.widgets.CListView', array(
                'id'=>'cart-details-list',
                'template'=>'{items}<div class="catalog-pager">{pager}</div>',
                'dataProvider'=>$cartDataProvider,
                'itemView'=>'_cart_item',
                'pagerCssClass'=>'container',
                'emptyTagName'=>'div',
                'emptyText'=>'',
                'updateSelector'=>'.catalog-pager a',
                'pager'=>array(
                    'class'=>'application.widgets.ELinkPager',
                    'cssFile'=>false,
                    'header'=>'',
                    'firstPageLabel'=>'',
                    'prevPageLabel'=>'',
                    'previousPageCssClass'=>'arrow left',
                    'nextPageLabel'=>'',
                    'nextPageCssClass'=>'arrow right',
                    'lastPageLabel'=>'',
                    'htmlOptions'=>array(
                        'class'=>''
                    ),
                )
            )); ?>
        </form>
    </div>
</div>
<div class="subtotal icons">
    <div class="container">
        <div class="span1">
            <div class="select cart-icon select-icon"></div>
            Выделен (1)
        </div>
        <div class="span1">
            <div class="select cart-icon hold-icon"></div>
            Отложить (1)
        </div>
        <div class="span1">
            <div class="select cart-icon delete-icon"></div>
            Удалить (1)
        </div>
        <div class="span5"></div>
        <div class="span2"><span class="georgia summ">7919 р.</span> Итого</div>
        <div class="span1"><div class="select cart-icon pay-icon"></div>Оплатить</div>
    </div>
</div>
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