<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление <?php echo $model->translition(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'details-grid',
	'dataProvider'=>$model->search(Details::TYPE_DETAIL),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('details')}",
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
		'name',
        'article_alias',
        array(
            'name'=>'brand_id',
            'type'=>'raw',
            'value'=>'$data->brand->name',
            'filter'=>CHtml::listData(Brands::model()->findAll(array('order'=>'name')), 'id', 'name'),
        ),
        array(
            'name'=>'category_id',
            'type'=>'raw',
            'value'=>'$data->category->name',
            'filter'=>CHtml::listData(DetailCategory::model()->findAll(array('order'=>'name')), 'id', 'name'),
        ),
        array(
            'name'=>'price',
            'type'=>'raw',
            'value'=>'SiteHelper::priceFormat($data->price, "р.")',
            'filter'=>$model->price,
        ),
		'in_stock',
        array(
            'header'=>'Применение',
            'class'=>'admin.widgets.AdaptabillitiColumn',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("details");', CClientScript::POS_END) ;?>