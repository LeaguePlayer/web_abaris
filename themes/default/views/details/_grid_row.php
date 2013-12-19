<div class="catalog-grid-row <?php if ( $data->id === $searchedId ) echo 'search' ?>">
    <div class="container">
        <div class="row-fluid">
<!--            <div class="span1 field img">--><?php //echo $data->getImage('small'); ?><!--</div>-->
            <div class="span2 field"><div class="valign-text"><p><a class="view_brand" href="<?php if ($data->brand) echo $data->brand->getViewUrl(); ?>"><?php if ($data->brand) echo $data->brand->name; ?></a></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->name; ?></p></div></div>
            <div class="span2 field">
                <div class="valign-text">
                    <p>
                        <?php if ( $data->in_stock == 0 ): ?>
                            <a class="send_question" href="<?php echo $this->createUrl('site/question', array('questArticle'=>$data->article)) ?>">Узнать о поступлениях</a>
                        <?php else: ?>
                            <b><?php echo $data->toStringStock(); ?></b>
                            <span class="stock_specify"><?php echo $data->getStockSpecify() ?></span>
                        <?php endif ?>
                    </p>
                </div>
            </div>
            <div class="span1 field">
                <div class="valign-text">
                    <p>
                        <?php if ( $data->in_stock == 0 ): ?>
                            —
                        <?php else: ?>
                            <?php echo $data->toStringDeliveryTime(); ?>
                        <?php endif ?>
                    </p>
                </div>
            </div>
            <div class="span2 field">
                <div class="valign-text">
                    <p><?php echo $data->toStringPrice() ?></p>
                </div>
            </div>
            <div class="span1 field">
                <div class="valign-text <?php if ( $data->price > 0 && $data->in_stock > 0 ) echo 'price' ?>">
                    <?php if ( $data->price > 0 && $data->in_stock > 0 ): ?>
                        <a class="to_cart" data-id="<?php echo $data->getId(); ?>" href="<?php echo $this->createUrl('/user/cart/put', array('key'=>$data->getId())); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>