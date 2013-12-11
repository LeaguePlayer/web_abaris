<?php
$this->breadcrumbs=array(
	'Banners'=>array('index'),
	$model->title,
);

<h1>View Banner #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'img_photo',
		'url',
		'target',
		'title',
		'description',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
