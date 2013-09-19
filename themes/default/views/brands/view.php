<?php
$this->breadcrumbs=array(
	'Brands'=>array('index'),
	$model->name,
);

<h1>View Brands #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'alias',
		'name',
		'img_logo',
		'wswg_description',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
