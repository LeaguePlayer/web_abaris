<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление складами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'depot-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('depot')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
    )',
	'columns'=>array(
		'name',
		'address',
		'id_1C',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("depot");', CClientScript::POS_END) ;?>