<?php
$this->breadcrumbs=array(
	"Поставщики"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Добавление постащик</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>