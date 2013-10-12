<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title><?php echo CHtml::encode(Yii::app()->name).' | Admin';?></title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
	  
		<?php
			$menuItems = array(
                array('label'=>'Главная', 'url'=>'/admin/start/index'),
				array('label'=>'Настройки', 'url'=>'/admin/start/settings'),
				array('label'=>'Разделы', 'url'=>'#', 'items' => array(
					array('label'=>'Брэнды', 'url'=>'/admin/brands/list'),
                    array('label'=>'Модели авто', 'url'=>'/admin/autoModels/list'),
                    array('label'=>'Типы кузовов', 'url'=>'/admin/bodytypes/list'),
                    array('label'=>'Двигатели', 'url'=>'/admin/engines/list'),
                    array('label'=>'Категории', 'url'=>'/admin/detailCategory/list'),
                    array('label'=>'Страницы', 'url'=>'/admin/pages/list'),
                    array('label'=>'Заказы пользователей', 'url'=>'/admin/orders/list'),
                    array('label'=>'Товары', 'items'=>array(
                        array('label'=>'Детали', 'url'=>'/admin/details/list'),
                        array('label'=>'Аксессуары', 'url'=>'/admin/accessory/list'),
                        array('label'=>'Расходные материалы', 'url'=>'/admin/consumable/list'),
                    )),
					array('label'=>'Не найденые запчасти', 'url'=>'/admin/detailsnofound/list'),
				)),
			);
		?>
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
			'color'=>'inverse', // null or 'inverse'
			'brandLabel'=> CHtml::encode(Yii::app()->name),
			'brandUrl'=>'/',
			'fluid' => true,
			'collapse'=>true, // requires bootstrap-responsive.css
			'items'=>array(
				array(
					'class'=>'bootstrap.widgets.TbNav',
					'items'=>$menuItems,
				),
				array(
					'class'=>'bootstrap.widgets.TbNav',
					'htmlOptions'=>array('class'=>'pull-right'),
					'items'=>array(
						array('label'=>'Выйти', 'url'=>'/user/logout'),
					),
				),
			),
		)); ?>

		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span1">
				<?php $this->widget('bootstrap.widgets.TbNav', array(
					'type'=>'list',
					'items'=> $this->menu
					)); ?>
				</div>
				<div class="span11">
					<?php echo $content;?>
				</div>
			</div>
		</div>

	</body>
</html>
