<?php
$this->breadcrumbs=array(
	'Details No Founds'=>array('index'),
	$model->id,
);

<h1>View DetailsNoFound #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'mail',
		'article',
		'date_find',
	),
)); ?>
