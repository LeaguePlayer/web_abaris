<?php $url = $this->getController()->createUrl('/details/view'); ?>
<?php echo CHtml::beginForm($url, 'get', array('class'=>'search-form')); ?>
<div class="input-wrap clearfix">
    <?php echo CHtml::activeTextField($form, 'string', array('class'=>'search-input', 'placeholder'=>'Поиск...')); ?>
    <?php echo CHtml::submitButton('', array('class'=>'search-button')); ?>
</div>
<?php echo CHtml::endForm(); ?>