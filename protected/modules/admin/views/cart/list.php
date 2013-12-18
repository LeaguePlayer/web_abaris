
<h1>Корзины пользователей</h1>

<div class="row-fluid">
    <div class="span6">
        <?php
        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'details-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'type'=>TbHtml::GRID_TYPE_HOVER,
            'columns'=>array(
                'id',
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{view}',
                ),
            ),
        ));
        ?>
    </div>
</div>
