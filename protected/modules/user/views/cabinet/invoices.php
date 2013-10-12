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
                    <div class="catalog-grid-row">
                         <div class="container">
                            <div class="row-fluid">
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p><a href="#">Блок цилиндров</a></p>
                                    </div>
                                </div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p>21</p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p>2006</p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p>Не оплачен</p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><a href="#">Оплатить</a></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><a href="#" class="admin-icon admin-icon-print-b"></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-grid-row active-grey">
                         <div class="container">
                            <div class="row-fluid">
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p><a href="#">Блок цилиндров</a></p>
                                    </div>
                                </div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p>21</p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p>2006</p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p>Оплачен</p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><a href="#" class="admin-icon admin-icon-print-b"></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </form>
    <!-- end list -->
</div>