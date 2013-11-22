<div class="catalog-grid-row <?php if ($model->id === $findedDetail->id) echo 'search'; ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span1 field img"><?php echo $model->getImage('small'); ?></div>
            <div class="span2 field"><div class="valign-text"><p><a class="view_brand" href="<?php if ($model->brand) echo $model->brand->getViewUrl(); ?>"><?php if ($model->brand) echo $model->brand->name; ?></a></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $model->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $model->name; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $model->in_stock; ?></p></div></div>
            <div class="span1 field"><div class="valign-text"><p><?php echo $model->delivery_time; ?></p></div></div>
            <div class="span2 field <?php if ( $model->price > 0 && $model->in_stock > 0 ) echo 'price' ?>">
                <div class="valign-text">
                    <p><?php echo $model->toStringPrice($price); ?></p>
                    <?php if ( $model->price > 0 && $model->in_stock > 0 ): ?>
                        <a class="to_cart" data-id="<?php echo $model->getId(); ?>" href="<?php echo $this->createUrl('/user/cart/put', array('key'=>$model->getId())); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>