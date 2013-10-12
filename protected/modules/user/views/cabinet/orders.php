<div id="usercabinet-wrap">

    <?php echo $this->renderPartial('_cabinet_steps'); ?>

    <form action="" method="POST">
        <!-- begin list-->
        <div class="catalog-container">
            <div class="catalog-grid">
                <div class="catalog-grid-header">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Наименование<br><input type="text"></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p class="bottom">Номер заказа<br><input type="text"></p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Даты оформление заказа<br><input type="text"></p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Примерная дата доставки<br><input type="text"></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p class="bottom">Стоимость<br><input type="text"></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Оплатить</p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Статус<br>
                                        <select name="" id="">
                                            <option value="">Отправлено</option>
                                            <option value="">Отправлено</option>
                                            <option value="">Отправлено</option>
                                        </select>
                                    </p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>В архив</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'orders-list',
                    'template'=>'{items}',
                    'dataProvider'=>$ordersDataProvider,
                    'itemView'=>'_order_item',
                    'emptyTagName'=>'div',
                    'emptyText'=>'<div class="container">Нет заказов</div>',
                    'updateSelector'=>'.catalog-pager a',
                )); ?>

            </div>
        </div>

        <div class="subtotal icons">
            <div class="container">
                <div class="span9"></div>
            </div>
        </div>

        <!-- end list -->
    </form>

</div>