<?php
$this->breadcrumbs=array(
	"Категории"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Добавление категории</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>