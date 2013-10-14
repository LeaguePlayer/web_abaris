<div class="catalog-grid-row active-grey">
    <div class="container">
        <div class="row-fluid">
            <div class="field span1">
                <div class="valign-text">
                    <p><a href="<?php echo $data->viewUrl; ?>"><?php echo $data->id;?></a></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo SiteHelper::russianDate($data->order_date); ?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo SiteHelper::russianDate($data->delivery_date); ?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><?php echo $data->full_cost; ?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><a href="#" class="admin-icon admin-icon-money-g"></a></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo $data->getOrderStatus(); ?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><a class="admin-icon admin-icon-box-g" href="#"></a></p>
                </div>
            </div>
        </div>
    </div>
</div>