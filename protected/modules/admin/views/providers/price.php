
<?php
$this->menu=array(
    array('label'=>'Список','url'=>array('list')),
    array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Загрузка прайсов</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'providers-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <?php foreach ($providers as $i=>$provider): ?>
    <div class="control-group">
        <label class="control-label" for=""><?php echo $provider->name ?></label>
        <div class="control">
            <?php echo $form->fileField($provider, "[$i]priceFile") ?>
        </div>
        <?php echo $form->error($provider, "[$i]priceFile") ?>
    </div>
    <?php endforeach ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton('Начать загрузку', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/autoModels/list')); ?>
    </div>

<?php $this->endWidget(); ?>