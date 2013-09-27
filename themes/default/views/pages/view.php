<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title,
);

<h1>View Pages #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'alias',
		'menu_title',
		'wswg_content',
		'meta_title',
		'meta_key',
		'meta_description',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
