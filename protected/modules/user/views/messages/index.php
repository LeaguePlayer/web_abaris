<?php
$this->breadcrumbs = array(
    'Ваши уведомления',
);
?>

<div id="content-wrap">

    <div class="container page-title">
        <h2 class="georgia">Ваши уведомления</h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>

    <!-- begin list-->
    <form method="POST" action="">

        <div class="catalog-container grid-items">
            <div class="catalog-grid">

                <div class="catalog-grid-header">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p>Создано</p>
                                </div>
                            </div>
                            <div class="field span7">
                                <div class="valign-text">
                                    <p>Сообщение</p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p>От кого</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'messages-list',
                    'template'=>'{items}',
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_message-row',
                    'emptyTagName'=>'div',
                    'emptyText'=>'<div class="container">Нет сообщений</div>',
                    'updateSelector'=>'.catalog-pager a',
                )); ?>

            </div>
        </div>

        <div class="subtotal icons">
            <div class="container">
                <div class="span10"></div>
                <button class="span1 item delete" type="submit" name="Messages[action]" value="delete">
                    <span class="icon cart-icon delete-icon"></span>
                    <span class="text">Удалить (<span class="selected_count">0</span>)</span>
                </button>
            </div>
        </div>

    </form>
    <!-- end list -->
</div>