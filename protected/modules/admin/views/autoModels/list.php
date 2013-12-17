<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление моделями автомобилей</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'auto-models-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('automodels')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".$data->status,
    )',
	'columns'=>array(
        array(
            'header'=>'Фото',
            'type'=>'raw',
            'value'=>'TbHtml::image($data->imgBehaviorPhoto->getImageUrl("small"))'
        ),
        array(
            'name'=>'brand_id',
            'type'=>'raw',
            'value'=>'$data->brand->name',
            'filter'=>CHtml::listData(Brands::model()->findAll(array('order'=>'name')), 'id', 'name')
        ),
        'name',
		array(
			'name'=>'dt_release_date',
			'type'=>'raw',
			'value'=>'SiteHelper::russianDate($data->dt_release_date)'
		),
		array(
			'name'=>'dt_end_release_date',
			'type'=>'raw',
			'value'=>'SiteHelper::russianDate($data->dt_end_release_date)'
		),
		'number_doors',
        array(
            'name'=>'bodytype_id',
            'type'=>'raw',
            'value'=>'$data->bodytype->name',
            'filter'=>CHtml::listData(Bodytypes::model()->findAll(), 'id', 'name')
        ),
		'VIN',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("automodels");', CClientScript::POS_END) ;?>