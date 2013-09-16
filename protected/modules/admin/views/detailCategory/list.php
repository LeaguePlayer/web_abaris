<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Категории</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'detail-category-grid',
	'dataProvider'=>$model->search(),
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
    )',
	'columns'=>array(
        array(
            'header'=>'Категория',
            'type'=>'raw',
            'value'=>'($data->level == 0) ? CHtml::openTag("b").$data->name.CHtml::closeTag("b") : " -------- ".$data->name'
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("detailcategory");', CClientScript::POS_END) ;?>