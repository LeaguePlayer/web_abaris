<?php
$this->breadcrumbs=array(
	"Типы кузовов"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Модель кузова - Добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>