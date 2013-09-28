<div class="catalog-grid-row<?php if ( $data->isArchived() ) echo ' archived' ?>"
     data-price="<?=$data->price;?>"
     data-count="<?=$data->getQuantity();?>"
     data-discount="<?=$data->discount + $userDiscount->discount;?>"
>
    <div class="container">
        <div class="row-fluid">
            <div class="span1 field no-background">
                <div class="valign-text">
                    <p>
                        <span class="blue-check">
                            <input name="CartItems[status][<?=$data->id;?>]" value="<?=$data->cartInfo->status;?>" type="hidden"/>
                            <input name="CartItems[checked][]" value="<?=$data->id;?>" id="check<?=$data->id;?>" type="checkbox"/>
                            <label for="check<?=$data->id?>"></label>
                        </span>
                    </p>
                </div>
            </div>
            <div class="span2 field img no-background"><?php echo $data->getImage('small'); ?></div>
            <div class="span4 field left">
                <div class="valign-text">
                    <p><a href="#"><?php echo $data->name; ?></a><br>производитель <?php echo $data->brand->name; ?><br>код: <?php echo $data->article; ?></p>
                </div>
            </div>
            <div class="span2 field">
                <div class="valign-text">
                    <p><input data-prise="<?=$data->price;?>" data-discount="<?=$data->discount + $userDiscount->discount;?>" name="CartItems[count][<?=$data->id?>]" class="spinner" value="<?php echo $data->getQuantity(); ?>"</p>
                </div>
            </div>
            <div class="span2 field price_values">
                <div class="valign-text">
                    <p>
                        <span class="red current_price"><?php echo SiteHelper::priceFormat($data->getSumPrice(false)); ?></span> руб. <br>
                        <span class="blue discount_value"><?php echo $data->discount + $userDiscount->discount; ?> %</span><br>
                        <span class="blue price_with_discount"><?php echo SiteHelper::priceFormat($data->getSumPrice()); ?></span> руб.
                    </p>
                </div>
            </div>
            <div class="span1 field"><div class="valign-text"><p>14 дней</p></div></div>
        </div>
    </div>
    <?php if ( $data->isArchived() ): ?>
    <div class="disabled_row"></div>
    <?php endif; ?>
</div>