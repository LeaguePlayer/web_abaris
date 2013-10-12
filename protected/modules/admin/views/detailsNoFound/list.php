<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление <?php echo $model->translition(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'details-no-found-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
   
	'columns'=>array(
	
		'article',
		'cnt',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>"{view}",
			'buttons'=>array
                    (
                     
						 'view' => array
                        (
                            'url'=>'Yii::app()->createUrl("/admin/detailsnofound/listbyarticle/article/$data->article")',
							//'options'=>array('target'=>"_blank"),
                        ),
                        
                    ),
		),
	),
)); ?>

