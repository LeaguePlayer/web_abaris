<?php
$this->breadcrumbs = array(
    'Личный кабинет - Управление автомобилями',
);
?>

<div id="usercabinet-wrap">

    <?php echo $this->renderPartial('_cabinet_steps'); ?>

    <!-- begin list-->
    <form method="POST" action="">

        <div class="catalog-container grid-items">
            <div class="catalog-grid">

                <div class="catalog-grid-header">
                    <div class="container">
                        <div class="row-fluid filter">
                            <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                            <div class="field span3">
                                <div class="valign-text">
                                    <p>Марка<br><?= CHtml::activeTextField($carsFinder, 'brand') ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Модель<br><?= CHtml::activeTextField($carsFinder, 'model') ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Пробег<br><?= CHtml::activeTextField($carsFinder, 'mileage') ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Год<br><?= CHtml::activeTextField($carsFinder, 'year') ?></p>
                                </div>
                            </div>
                            <div class="field span3">
                                <div class="valign-text">
                                    <p>VIN номер<br><?= CHtml::activeTextField($carsFinder, 'VIN') ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Редактировать</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo $this->renderPartial('_cars_grid_body', array(
                    'dataUserListCars' => $dataUserListCars
                )) ?>

            </div>
        </div>

        <div class="subtotal icons">
            <div class="container">
                <div class="span9"></div>
                <a class="span1 item add" href="<?=$this->createUrl('/user/cabinet/carForm')?>">
                    <span class="icon cart-icon add-icon"></span>
                    <span class="text">Добавить</span>
                </a>
                <button class="span1 item delete" type="submit" name="Cars[action]" value="delete">
                    <span class="icon cart-icon delete-icon"></span>
                    <span class="text">Удалить (<span class="selected_count">0</span>)</span>
                </button>
            </div>
        </div>

    </form>
    <!-- end list -->
</div>