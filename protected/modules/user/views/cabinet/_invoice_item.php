<div class="catalog-grid-row active-grey">
    <div class="container">
        <div class="row-fluid">
            <div class="field span3">
                <div class="valign-text">
                    <p><a class="view-invoice" href="<?php echo $this->createUrl('/userInvoices/view', array('id'=>$data->id)); ?>">Счет №<?php echo $data->invoice_number; ?></a></p>
                </div>
            </div>
            <div class="field span3">
                <div class="valign-text">
                    <p><?php echo SiteHelper::russianDate($data->date); ?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo $data->cost; ?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?php echo $data->payStatus; ?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <?php if ( $data->isPayd() ): ?>
                        <p></p>
                    <?php else: ?>
                        <p><a href="#">Оплатить</a></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><a href="<?php echo $data->printUrl; ?>" class="admin-icon admin-icon-print-b print-page"></a></p>
                </div>
            </div>
        </div>
    </div>
</div>