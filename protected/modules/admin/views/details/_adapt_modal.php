<h3>Применение детали "<?php echo $detail->name ?>"</h3>

<div class="container">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'adaptabilliti-form',
        'enableAjaxValidation'=>false,
    )); ?>
        <?php
            if ( Yii::app()->user->hasFlash('SUCCESS_ADAPTABILLITI') )
                echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('SUCCESS_ADAPTABILLITI'));
        ?>
        <?php
            echo $form->dropDownListControlGroup($adaptabilliti, 'auto_model_id', CHtml::listData($autoModels, 'id', 'name'),array('class'=>'span8','maxlength'=>45));
        ?>
        <div class="clear"></div>
        <div class="control-group" style="margin-top: 10px;">
            <?php echo TbHtml::submitButton('Добавить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        </div>
    <?php $this->endWidget() ?>

    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'adapt-grid',
        'filter'=>false,
        'dataProvider'=>new CArrayDataProvider($adaptModels, array(
            'pagination'=>array(
                'pageSize'=>100
            )
        )),
        'type'=>TbHtml::GRID_TYPE_HOVER,
        'rowHtmlOptionsExpression'=>'array(
            "data-auto_model_id"=>$data->id,
            "data-detail_id"=>'.$adaptabilliti->detail_id.',
        )',
        'columns'=>array(
            array(
                'header'=>'Подходит к',
                'type'=>'raw',
                'value'=>'Авто',
            ),
            array(
                'header'=>'Название',
                'type'=>'raw',
                'value'=>'$data->name',
            ),
            array(
                'type'=>'raw',
                'value'=>"TbHtml::linkButton('', array(
                    'class' => 'remove',
                    'color' => TbHtml::BUTTON_COLOR_DANGER,
                    'size' => TbHtml::BUTTON_SIZE_MINI,
                    'icon' => TbHtml::ICON_REMOVE,
                    'iconOptions' => array(
                        'color' => TbHtml::ICON_COLOR_WHITE
                    )
                ))",
            )
        ),
    )); ?>
</div>