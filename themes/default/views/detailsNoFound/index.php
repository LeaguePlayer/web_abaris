<?php
/* @var $this DetailsNoFoundController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Details No Founds',
);

$this->menu=array(
	array('label'=>'Create DetailsNoFound', 'url'=>array('create')),
	array('label'=>'Manage DetailsNoFound', 'url'=>array('admin')),
);
?>

<h1>Details No Founds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
