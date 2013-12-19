<div class="catalog-grid-row<?php if ( $currentEngineId === $data->id ) echo ' select'; ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="field span8">
                <div class="valign-text"><p><?php echo $data->name; ?></p></div>
            </div>
            <!--            <div class="field span2">-->
            <!--                <div class="valign-text"><p>--><?php //echo $data->volume; ?><!--</p></div>-->
            <!--            </div>-->
            <!--            <div class="field span2">-->
            <!--                <div class="valign-text"><p>--><?php //echo $data->getFuelType(); ?><!--</p></div>-->
            <!--            </div>-->
            <!--            <div class="field span2">-->
            <!--                <div class="valign-text"><p>--><?php //echo $data->power; ?><!--</p></div>-->
            <!--            </div>-->
            <div class="field span4">
                <div class="valign-text"><p><a href="<?php echo $this->createurl('/consumable/details', array('model_id'=>$autoModel->id, 'engine_id'=>$data->id, 'brand'=>$this->brand['alias'])); ?>" class="b-button b-button-blue">Выбрать</a></p></div>
            </div>
        </div>
    </div>
</div>