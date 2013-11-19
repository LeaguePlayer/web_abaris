<?php if ($data->id === $findedDetail->id): ?>
    <div class="catalog-grid-subhead">
        <div class="container">
            <a href="#">Запрошенный артикул</a>
        </div>
    </div>
<?php elseif ( $data->id === $firstAnalogId ): ?>
    <div class="catalog-grid-subhead">
        <div class="container">
            <a href="#">Список аналогов</a>
        </div>
    </div>
<?php endif ?>

<div class="catalog-grid-row <?php if ($data->id === $findedDetail->id) echo 'search'; ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span2 field img"><?php echo $data->getImage('small'); ?></div>
            <div class="span2 field"><div class="valign-text"><p><a class="view_brand" href="<?php if ($data->brand) echo $data->brand->getViewUrl(); ?>"><?php if ($data->brand) echo $data->brand->name; ?></a></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->name; ?></p></div></div>
            <div class="span1 field"><div class="valign-text"><p><?php echo $data->toStringInStock(); ?></p></div></div>
            <div class="span1 field"><div class="valign-text"><p>14 дней</p></div></div>
            <div class="span2 field <?php if ( $data->price > 0 ) echo 'price' ?>">
                <div class="valign-text">
                    <p><?php echo $data->toStringPrice(); ?></p>
                    <?php if ( $data->price > 0 ): ?>
                        <a class="to_cart" data-id="<?php echo $data->id; ?>" href="<?php echo $this->createUrl('/user/cart/put', array('id'=>$data->id)); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>