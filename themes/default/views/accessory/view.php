<?php
$this->breadcrumbs=array(
	'Details'=>array('index'),
	$model->name,
);

<h1>View Details #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'article',
		'name',
		'price',
		'in_stock',
		'dt_delivery_date',
		'img_photo',
		'wswg_description',
		'brand_id',
		'category_id',
		'status',
		'sort',
		'create_time',
		'update_time',
		'discount',
		'type',
	),
)); ?>
