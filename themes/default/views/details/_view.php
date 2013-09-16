<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="span2 field img"><?php echo $data->getImage('small'); ?></div>
            <div class="span1 field"><div class="valign-text"><p><?php echo $data->brand->name; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->article; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->name; ?></p></div></div>
            <div class="span2 field"><div class="valign-text"><p><?php echo $data->toStringInStock(); ?></p></div></div>
            <div class="span1 field"><div class="valign-text"><p>14 дней</p></div></div>
            <div class="span2 field price"><div class="valign-text"><p><?php echo $data->toStringPrice(); ?></p></div></div>
        </div>
    </div>
</div>