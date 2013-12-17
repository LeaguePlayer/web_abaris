
<h1>Управление заказами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'orders-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {jQuery('#Orders_order_date').datepicker({'format':'dd.mm.yyyy','autoclose':true, 'language':'ru'});}",
    'rowHtmlOptionsExpression'=>'array(
        "class"=>$data->isPayd() ? "success" : ($data->isNopayd() ? "error" : ($data->isWork() ? "warning" : "info"))
    )',
	'columns'=>array(
		'SID',
        array(
            'name'=>'order_date',
            'type'=>'raw',
            'value'=>'date("d.m.Y H:i", strtotime($data->order_date))',
            'filter'=>$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'order_date',
                    'pluginOptions' => array(
                        'format' => 'dd.mm.yyyy',
                        'language' => 'ru'
                    ),
                ),
                true
            ),
        ),
		array(
            'name'=>'paytype',
            'type'=>'raw',
            'value'=>'$data->getCurrentPaytype()',
            'filter'=>Orders::getPaytypes()
        ),
        array(
            'name'=>'order_status',
            'type'=>'raw',
            'value'=>'$data->getOrderStatus()',
            'filter'=>Orders::getStatusLabels()
        ),
		'cart_id',
        array(
            'name'=>'recipientFio',
            'type'=>'raw',
            'value'=>'$data->getRecipientFio()',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{work}{view}{delete}',
            'buttons'=>array(
                'work'=>array(
                    'label'=>'Приступить',
                    'options'=>array(
                        'class'=>'work',
                    )
                )
            )
		),
	),
)); ?>