<div class="catalog-grid-row no-hover small-height">
    <div class="container">
        <div class="row-fluid">
            <div class="field span4">
                <div class="valign-text">
                    <p><?php echo $data->name ?></p>
                </div>
            </div>
            <div class="field span4">
                <div class="valign-text">
                    <p><?php echo $data->article ?></p>
                </div>
            </div>
            <div class="field span3">
                <div class="valign-text">
                    <p><a href="<?php echo $this->createUrl('details/view', array('id'=>$data->id, 'model_id'=>$autoModel->id, 'cat'=>$data->category_id, 'brand'=>$this->brand['alias'])); ?>">Посмотреть цену и наличие товара</a></p>
                </div>
            </div>
        </div>
    </div>
</div>