<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="field span2">
                <div class="valign-text"><p><?php echo $data->volume; ?></p></div>
            </div>
            <div class="field span2">
                <div class="valign-text"><p><?php echo $data->getFuelType(); ?></p></div>
            </div>
            <div class="field span2">
                <div class="valign-text"><p><?php echo $data->power; ?></p></div>
            </div>
            <div class="field span4">
                <div class="valign-text"><p><a href="<?php echo $this->createurl('/catalog/details', array('model_id'=>$autoModel->id, 'engine_id'=>$data->id)); ?>" class="b-button b-button-blue">Выбрать</a></p></div>
            </div>
        </div>
    </div>
</div>