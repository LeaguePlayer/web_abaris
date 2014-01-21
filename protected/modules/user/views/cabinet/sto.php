<?php
$this->breadcrumbs = array(
    'Личный кабинет - Управление СТО',
);
?>

<div id="usercabinet-wrap">

    <?php echo $this->renderPartial('_cabinet_steps'); ?>

    <form action="" method="POST">
        <!-- begin list-->
        <div class="catalog-container grid-items">
            <div class="catalog-grid">
                <div class="catalog-grid-header">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Автомобиль<br>
                                        <?php echo CHtml::activeDropDownList($stoFinder, 'user_car_id', CHtml::listData(Yii::app()->user->model()->cars, 'id', 'model'), array('empty'=>'-')); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Дата прохождения ТО<br><?php echo CHtml::activeTextField($stoFinder, 'maintenance_date', array('id'=>'UserCarsSTO_maintenance_date-filter')); ?></p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Название ТО<br><?php echo CHtml::activeTextField($stoFinder, 'maintenance_name'); ?></p>
                                </div>
                            </div>
                            <div class="field span2">
                                <div class="valign-text">
                                    <p class="bottom">Вид работ<br><?php echo CHtml::activeDropDownList($stoFinder, 'maintenance_type', UserCarsSTO::getMaintenanceTypes(), array('empty'=>'-')); ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p class="bottom">Сумма затрат<br><?php echo CHtml::activeTextField($stoFinder, 'maintenance_cost'); ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p class="bottom">Затраты на АЗС<br><?php echo CHtml::activeTextField($stoFinder, 'azs_cost'); ?></p>
                                </div>
                            </div>
                            <div class="field span1">
                                <div class="valign-text">
                                    <p>Редакти-<br>ровать</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'sto-list',
                    'template'=>'{items}',
                    'dataProvider'=>$dataUserListSTO,
                    'itemView'=>'_item_STO',
                    'emptyTagName'=>'div',
                    'emptyText'=>'<div class="container">Нет записей</div>',
                    'updateSelector'=>'.catalog-pager a',
                )); ?>


            </div>
        </div>


        <div class="subtotal icons">
            <div class="container">
                <div class="span9"></div>
                <a class="span1 item add" href="<?=$this->createUrl('/user/cabinet/stoForm')?>">
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
</div>
