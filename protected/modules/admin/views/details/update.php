<?php
$this->breadcrumbs=array(
	"{$model->translition()}"=>array('list'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('list')),
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1><?php echo $model->name; ?> - Редактирование</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>