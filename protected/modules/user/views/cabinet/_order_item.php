<div class="catalog-grid-row active-grey">
    <div class="container">
        <div class="row-fluid">
            <div class="field span1">
                <div class="valign-text">
                    <p><a class='view-order' href="<?php echo $data->viewUrl; ?>">Заказ №<?php echo $data->id;?></a></p>
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
                    <?php if ( $data->isArchived() or $data->status == Orders::ORDERSTATUS_PAYD ): ?>
                        <p><a href="#" class="admin-icon admin-icon-money-g"></a></p>
                    <?php else: ?>
                        <p><a href="#" class="admin-icon admin-icon-money-b"></a></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo $data->getOrderStatus(); ?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <?php if ( $data->isArchived() ): ?>
                        <p><a class="admin-icon admin-icon-box-g" href="<?php echo $data->archiveAction; ?>"></a></p>
                    <?php else: ?>
                        <p><a class="admin-icon admin-icon-box-b" href="<?php echo $data->archiveAction; ?>"></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>