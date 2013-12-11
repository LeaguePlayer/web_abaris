<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление <?php echo $model->translition(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'banner-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('banner')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".$data->status,
    )',
	'columns'=>array(
		array(
			'header'=>'Фото',
			'type'=>'raw',
			'value'=>'TbHtml::imageCircle($data->imgBehaviorPhoto->getImageUrl("icon"))'
		),
		'url',
		'target',
		'title',
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'Banner::getStatusAliases($data->status)',
			'filter'=>Banner::getStatusAliases()
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("banner");', CClientScript::POS_END) ;?>