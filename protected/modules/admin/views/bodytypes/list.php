<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Типы кузовов</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'bodytypes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
    )',
	'columns'=>array(
		'name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>