<?php
$this->menu=array(
    array('label'=>'Назад','url'=>array('list')),
);
?>

<?php
    $attributes = array(
        'sid',
        array(
            'name'=>'order_date',
            'type'=>'raw',
            'value'=>date("d.m.Y H:i", strtotime($model->order_date))
        ),
        array(
            'name'=>'paytype',
            'type'=>'raw',
            'value'=>$model->getCurrentPaytype()
        ),
        array(
            'name'=>'order_status',
            'type'=>'raw',
            'value'=>$model->getOrderStatus()
        ),
    );
    $total = 0;
    foreach ( $model->positions as $position ) {
        $attributes[] = array(               // related city displayed as a link
            'label'=>$position->name,
            'type'=>'raw',
            'value'=>'Цена - '.SiteHelper::priceFormat($position->cost, 'руб').' ('.$position->count.' шт.)',
        );
        $total += $position->cost * $position->count;
    }
    $attributes[] = array(               // related city displayed as a link
        'label'=>'Всего',
        'type'=>'raw',
        'value'=>SiteHelper::priceFormat($total, 'руб'),
    );
?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'=>$model,
    'attributes'=>$attributes
)) ?>