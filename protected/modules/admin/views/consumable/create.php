<?php
$this->breadcrumbs=array(
	"{$model->translition()}"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Новый расходный материал</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>