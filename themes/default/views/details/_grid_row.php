<div class="catalog-grid-row <?php if ( $data->id === $searchedId ) echo 'search' ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span1 field img"><?php echo $data->getImage('small'); ?></div>
            <div class="span2 field"><div class="valign-text"><p><a class="view_brand" href="<?php if ($data->brand) echo $data->brand->getViewUrl(); ?>"><?php if ($data->brand) echo $data->brand->name; ?></a></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->name; ?></p></div></div>
            <div class="span2 field"><div class="valign-text">
                    <p>
                        <b><?php echo $data->getStock(); ?></b>
                        <span class="stock_specify"><?php echo $data->getStockSpecify() ?></span>
                    </p></div></div>
            <div class="span1 field"><div class="valign-text"><p><?php echo $data->delivery_time; ?></p></div></div>
            <div class="span2 field <?php if ( $data->price > 0 && $data->in_stock > 0 ) echo 'price' ?>">
                <div class="valign-text">
                    <p><?php echo $price ?></p>
                    <?php if ( $data->price > 0 && $data->in_stock > 0 ): ?>
                        <a class="to_cart" data-id="<?php echo $data->getId(); ?>" href="<?php echo $this->createUrl('/user/cart/put', array('key'=>$data->getId())); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>