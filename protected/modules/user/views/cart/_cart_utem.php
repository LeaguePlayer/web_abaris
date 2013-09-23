<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="span1 field no-background"><div class="valign-text"><p><span class="check blue-check"></span></p></div></div>
            <div class="span3 field img no-background"><?php echo $data->getImage('small'); ?></div>
            <div class="span4 field left">
                <div class="valign-text">
                    <p><a href="#"><?php echo $data->name; ?></a><br>производитель <?php echo $data->brand->name; ?><br>код: <?php echo $data->article; ?></p>
                </div>
            </div>
            <div class="span1 field">
                <div class="valign-text">
                    <p><input name="counter" class="spinner" value="1"></p>
                </div>
            </div>
            <div class="span2 field">
                <div class="valign-text">
                    <p>
                        <span class="red"><?php echo SiteHelper::priceFormat($data->getSumPrice(false)); ?></span> руб. <br>
                        <span class="blue"><?php echo $data->getDiscountRate(); ?> %</span><br>
                        <span class="blue"><?php echo SiteHelper::priceFormat($data->getSumPrice()); ?></span> руб.</p>
                </div>
            </div>
            <div class="span1 field"><div class="valign-text"><p>14 дней</p></div></div>
        </div>
    </div>
</div>