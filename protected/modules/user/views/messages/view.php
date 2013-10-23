<?php
$this->breadcrumbs=array(
	'Messages'=>array('index'),
	$model->id,
);

<h1>View Messages #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'message',
		'status',
		'user_id',
		'from',
		'create_time',
		'update_time',
	),
)); ?>
