
<?php
    $this->menu=array(
        array('label'=>'Список','url'=>array('list')),
    );
?>

<h3>Корзина № <?php echo $model->id ?></h3>

<div class="form">
    <?php
        $total = 0;
        foreach ( $model->cart_details as $i => $position ) {
            if ( $position->isArchived() )
                continue;
            $detail = $position->detail;
            $detail->setCartKey( $position->detail_key );
            $cost = $detail->getPrice();
            $discount = $detail->discount;
            $attributes[] = array(
                'label'=>$detail->name,
                'type'=>'raw',
                'value'=>'Цена - '.SiteHelper::priceFormat($cost, 'руб').', Скидка - '.$discount.'% <br>'.
                'Количество - '.$position->count.' шт',
            );
            $price = $cost * $position->count;
            $price = $price - $price * $discount / 100;
            $total += $price;
        }
        $attributes[] = array(
            'label'=>'Всего',
            'type'=>'raw',
            'value'=>SiteHelper::priceFormat($total, 'руб'),
        );
        ?>

        <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>$attributes
        )); ?>

        <?php echo TbHtml::linkButton('Оформить заявку', array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'url' => array('createOrder', 'cart_id'=>$model->id)
        )); ?>
</div>
