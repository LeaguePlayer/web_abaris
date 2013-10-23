<?php
/*$this->breadcrumbs = array(
    'Личный кабинет - Управление автомобилями',
);*/
?>

<div id="usercabinet-wrap">

    <?php echo $this->renderPartial('_cabinet_steps'); ?>

    <!-- begin list-->
    <form method="POST" action="">

        <div class="catalog-container">
                <div class="catalog-grid">

                    <div class="catalog-grid-header">
                        <div class="container">
                            <div class="row-fluid">
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p class="bottom">№ счета<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p class="bottom">Дата<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p class="bottom">Сумма<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p class="bottom">Статус<br>
                                            <?php echo CHtml::activeDropDownList($invoiceFinder, 'pay_status', UserInvoices::getStatusLabels(), array('empty'=>'-')); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Оплата</p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Печать</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->widget('zii.widgets.CListView', array(
                        'id'=>'orders-list',
                        'template'=>'{items}',
                        'dataProvider'=>$invoicesDataProvider,
                        'itemView'=>'_invoice_item',
                        'emptyTagName'=>'div',
                        'emptyText'=>'<div class="container">Нет записей</div>',
                        'updateSelector'=>'.catalog-pager a',
                    )); ?>

                </div>
            </div>

    </form>
    <!-- end list -->
</div>