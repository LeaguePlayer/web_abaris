<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="span2 field img"><?php echo $data->getImage('small'); ?></div>
            <div class="span1 field"><div class="valign-text"><p><a class="view_brand" href="<?php echo $data->brand->getViewUrl(); ?>"><?php echo $data->brand->name; ?></a></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->name; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->toStringInStock(); ?></p></div></div>
            <div class="span1 field"><div class="valign-text"><p>14 дней</p></div></div>
            <div class="span2 field price">
                <div class="valign-text">
                    <p><?php echo $data->toStringPrice(); ?></p>
                    <a class="to_cart" data-id="<?php echo $data->id; ?>" href="<?php echo $this->createUrl('/user/cart/put', array('id'=>$data->id)); ?>"></a>
                </div>
            </div>
        </div>
    </div>
</div>