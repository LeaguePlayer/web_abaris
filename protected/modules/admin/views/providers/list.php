<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
	array('label'=>'Загрузить прайсы','url'=>array('price')),
);
?>

<h1>Поставщики</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'providers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'columns'=>array(
		'name',
		'day_count',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("providers");', CClientScript::POS_END); ?>